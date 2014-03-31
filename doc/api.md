
User
====

get    /api/v1/user

get    /api/v1/user/:userName
post   /api/v1/user/:userName
put    /api/v1/user/:userName
delete /api/v1/user/:userName

get    /api/v1/user/:userName/ownProjects
get    /api/v1/user/:userName/projects
get    /api/v1/user/:userName/languages
get    /api/v1/user/:userName/translations


Project
=======

get    /api/v1/project

get    /api/v1/project/:projectName
post   /api/v1/project/:projectName
put    /api/v1/project/:projectName
delete /api/v1/project/:projectName

get    /api/v1/project/:projectName/owner
get    /api/v1/project/:projectName/members /contributors
get    /api/v1/project/:projectName/domains
get    /api/v1/project/:projectName/languages


Language
========

get    /api/v1/language

get    /api/v1/language/:locale
post   /api/v1/language/:locale
put    /api/v1/language/:locale
delete /api/v1/language/:locale

get    /api/v1/language/:locale/users
get    /api/v1/language/:locale/projects


Domain
======

get    /api/v1/domain

get    /api/v1/domain/:id
post   /api/v1/domain/:id
put    /api/v1/domain/:id
delete /api/v1/domain/:id

get    /api/v1/domain/:id/dataSets


DataSet
=======

get    /api/v1/dataSet

get    /api/v1/dataSet/:id
post   /api/v1/dataSet/:id
put    /api/v1/dataSet/:id
delete /api/v1/dataSet/:id

get    /api/v1/dataSet/:id/translations

