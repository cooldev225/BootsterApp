var map=null;
var locations;
var geocoder;
var infowindow;
let markers = [];
var icon_color=new Array('green','yellow','orange','red');
function loadLocations() {
    if(task_table==null)return;
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers = [];
    var bi=new Array(task_table.dataSet.length), bi_cnt=0;
    var pi=new Array(task_table.dataSet.length), pi_cnt=0;
    var f;
    var user_locations = new Array(task_table.dataSet.length*3);
    for(var i=0;i<task_table.dataSet.length;i++){
        user_locations[i] = new Array(5);
        user_locations[i][0] = task_table.dataSet[i].city;
        user_locations[i][1] = 'Business: '+task_table.dataSet[i].business_first_name+' '+task_table.dataSet[i].business_last_name+' , Project: '+task_table.dataSet[i].project_name+', Description: '+task_table.dataSet[i].description;
        user_locations[i][2] = 'Task '+(i+1)+':'+task_table.dataSet[i].username;//label
        user_locations[i][3] = icon_color[0];//[eval(task_table.dataSet[i].subgroup_id==null?task_table.dataSet[i].group_id:task_table.dataSet[i].subgroup_id)%4];//icon
        user_locations[i][4]=task_table.dataSet[i].id;
        f=0;for(var j=0;j<bi_cnt;j++)if(bi[j][4]==task_table.dataSet[i].business_id){f=1;break;}
        if(!f){
            bi[bi_cnt] = new Array(5);
            bi[bi_cnt][0] = task_table.dataSet[i].business_city;
            bi[bi_cnt][1] = task_table.dataSet[i].business_first_name+' '+task_table.dataSet[i].business_last_name
                +'<br>'+lang.project+': '+task_table.dataSet[i].project_name;
            bi[bi_cnt][2] = task_table.dataSet[i].business_first_name+' '+task_table.dataSet[i].business_last_name;
            bi[bi_cnt][3] = icon_color[3];
            bi[bi_cnt][4]=task_table.dataSet[i].business_id;
            bi_cnt++;
        }
        f=0;for(var j=0;j<pi_cnt;j++)if(pi[j][4]==task_table.dataSet[i].project_id){f=1;break;}
        if(!f){
            pi[pi_cnt] = new Array(5);
            pi[pi_cnt][0] = task_table.dataSet[i].project_city;
            pi[pi_cnt][1] = task_table.dataSet[i].project_description;
            pi[pi_cnt][2] = 'Prooject '+(pi_cnt+1)+':'+task_table.dataSet[i].project_name;//label
            pi[pi_cnt][3] = icon_color[1];
            pi[pi_cnt][4]=task_table.dataSet[i].project_id;
            pi_cnt++;
        }
    }
    var ui_cnt=0;//task_table.dataSet.length;
    pi_cnt=0;
    locations = new Array(ui_cnt+bi_cnt+pi_cnt);
    for(var i=0;i<ui_cnt;i++){
        locations[i]=new Array(5);
        for(var j=0;j<4;j++)locations[i][j]=user_locations[i][j];
    }
    for(var i=0;i<bi_cnt;i++){
        locations[ui_cnt+i]=new Array(5);
        for(var j=0;j<4;j++)locations[ui_cnt+i][j]=bi[i][j];
    }
    for(var i=0;i<pi_cnt;i++){
        locations[ui_cnt+bi_cnt+i]=new Array(5);
        for(var j=0;j<4;j++)locations[ui_cnt+bi_cnt+i][j]=pi[i][j];
    }
}
taskColumns=[
    {
        field: 'description',
        title: lang.description,
        width:200,
    },
    {
        field: 'business_name',
        title: lang.business,
        width:100,
        autoHide: false,
        template: function(row){
            return '<a data-toggle="modal" data-target="#viewBusinessModal" href="javascript:;" onclick="viewBusinessModal('+row.business_id+');">\
            '+row.business_first_name+' '+row.business_last_name+'\
            </a>';
        }
    },
    {
        field: 'project_name',
        title: lang.project,
        width:80,
    },
    {
        field: 'username',
        title: lang.user,
        width:100,
        sortable: 'asc',
    },

    {
        field: 'due_date',
        title: lang.datetofinish,
        width:100,
        template: function(row){
            return getJustDate(row.due_date);
        }
    },
    {
        field: 'group_name',
        title: lang.group,
    },
    {
        field: 'subgroup_name',
        title: lang.subgroup,
    },


];
function changeBusiness(id){
    var projects=$. parseJSON($('#project_object').val());
    $("#kt_datatable_search_project").empty();
    $("#kt_datatable_search_project").append($("<option></option>").attr("value", 0).text('___'+lang.all+'___'));
    if(projects.length==0||projects[id]==undefined)return;
    for(var i=0;i<projects[id].length;i++){
        $("#kt_datatable_search_project").append($("<option></option>").attr("value", projects[id][i].id).text(projects[id][i].name));
    }
}
jQuery(document).ready(function() {
    $('#kt_datatable_search_business').select2();
    $('#kt_datatable_search_business').on('change',function(){
        changeBusiness($(this).val());
        taskmapSearchAction();
    });
    $('#kt_datatable_search_project').select2();
    $('#kt_datatable_search_project').on('change',function(){
        taskmapSearchAction();
    });
    task_table.on('datatable-on-ajax-done',function(){
        loadLocations();
        for (i = 0; i < locations.length; i++) {
            geocodeAddress(i);
        }
    });
    taskmapSearchAction();
});
function taskmapSearchAction(){
    task_table.setDataSourceParam('q_business',$('#kt_datatable_search_business').val());
    task_table.setDataSourceParam('q_project',$('#kt_datatable_search_project').val());
    task_table.setDataSourceParam('user_id',$('#kt_datatable_search_user').val());
    task_table.reload();
}
function initAutocomplete(){
    var mapOptions = {
        center: new google.maps.LatLng(41.8719, 12.5674),
        zoom: 4,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow();
    map = new google.maps.Map(document.getElementById("map"), mapOptions);
}
function pinSymbol(color) {
    return {
        path: 'M 0,0 C -2,-20 -10,-22 -10,-30 A 10,10 0 1,1 10,-30 C 10,-22 2,-20 0,0 z',
        fillColor: color,
        fillOpacity: 1,
        strokeColor: '#000',
        strokeWeight: 2,
        scale: 1
    };
}
function geocodeAddress(i) {
    geocoder.geocode({ 'address': locations[i][0] }, function (results, status) {
        if (status === 'OK') {
            map.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: results[0].geometry.location,
                label: locations[i][2],
                icon: pinSymbol(locations[i][3])//'assets/img/icons/award.png'
            });
            markers.push(marker);
            //console.log(results[0]);
            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    infowindow.setContent(locations[i][1]);
                    infowindow.open(map, marker);
                    if (map.getZoom() == 4) {
                        map.setZoom(12);
                        map.setCenter(marker.getPosition());
                    } else {
                        map.setZoom(4);
                        map.setCenter(marker.getPosition());
                    }
                }

            })(marker, i));
        }
        else {
            // === if we were sending the requests to fast, try this one again and increase the delay
            if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                setTimeout(geocodeAddress(i), 500);
            } else {
                alert(lang.err_map+status);
            }
        }
    });
}
