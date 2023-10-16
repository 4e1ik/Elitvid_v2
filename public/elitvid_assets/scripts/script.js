i = 0;

var year = document.getElementById('years');
function letYears (i,year ) {
    if (i <= 15) {
        year.innerHTML = i;
        i++;
        setTimeout(function () {
            letYears(i, year)
        }, 100);
    }
}
letYears(i, year);

var project = document.getElementById('projects');
function letProjects (i,project ) {
    if (i <= 120) {
        project.innerHTML = i;
        i++;
        setTimeout(function () {
            letProjects(i, project)
        }, 10);
    }
}
letProjects(i, project);

var client = document.getElementById('clients');
function letClients (i,client ) {
    if (i <= 100) {
        client.innerHTML = i;
        i++;
        setTimeout(function () {
            letClients(i, client)
        }, 12);
    }
}
letClients  (i, client);


