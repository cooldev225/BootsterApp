var lang = {
    //login page
    req_username : "Username is required",
    req_password : "Password is required",
    err_login: "Sorry, looks like there are some errors detected, please try again.",
    conf_gotit: "Ok, got it!",
    req_firstname: "First name is required",
    req_lasttname: "Last name is required",
    req_confirm: "The password confirmation is required",
    req_email: "Email is required",
    err_email: "The value is not a valid email address",
    err_match: "The password and its confirm are not the same",
    req_accept: "You must accept the terms and conditions",
    err_dbluser: "Username you typed is already exist.",
    conf_try: "Please, try again!",
    err_dblemail: "Email you typed is already exist.",
    err_dblaccess: "You are Logged in on other devices.",
    //home page
    business: 'Business',
    group: 'Group',
    project: 'Project',
    process: 'Process',
    datetofinish: 'Date to finish',
    //project page
    dropattach: '<strong>Drop attach files here or click to upload. </strong></br> (File will be safe.)',
    //group page
    name: 'Name',
    firstalert: 'First Alert',
    secondalert: 'Second Alert',
    againalert: 'Again Alert',
    documents: 'Documents',
    createdby: 'Created By',
    createddate: 'Created Date',
    actions: 'Actions',
    all: 'ALL',
    //document page
    title: 'Title',
    duedate: 'Due date',
    subgroup: 'Sub Group',
    status: 'Status',
    opening: 'Opening',
    developing: 'Developing',
    waitingforclient: 'Waiting for client',
    onfiled: 'On filed',
    waitingorgan: 'Waiting organ',
    description: 'Description',
    createfile: 'Create file',
    user: 'User',
    location: 'Location',
    finishedat: 'Finsihed at',
    finishedby: 'Finished by',
    createtask: 'Create task',
    task: 'Task',
    license: 'License',
    //map view page
    err_map: 'Geocode was not successful for the following reason: ',
};
const kinds_of_document= new Array(
    'Expired Document',
    'Is on date to be done',
    'Open, but didn\'t arrive on time',
    'IN development',
    'Waiting for client',
    'Protocalada - filed',
    'Encerrada - closed - finish'
);
const trans_pagination={
    records: {
        processing: 'Loading...',
        noRecords: 'there is no record',
    },
    toolbar: {
        pagination: {
            items: {
                default: {
                    first: 'First',
                    prev: 'Previous',
                    next: 'Next',
                    last: 'Last',
                    more: 'More pages',
                    input: 'Page number',
                    select: 'Page size',
                },
                info: 'showing {{start}} - {{end}} of {{total}} records',
            },
        },
    },
};
