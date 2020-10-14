# DocsGo

* A Project Data Reporting Tool being a central place to view, generate all
important project reports from the various data sources.
* It will initially be a standalone module
that provides user a web interface with the features below. Later, we should be able to integrate
with Phabricator as an extension. 
* The recommended technologies used for this project will be
PHP, MySQL. In the UI, the PRT should have option to show all data or only specific for a new
release.

![image](https://user-images.githubusercontent.com/27942487/95953177-1c7e2d80-0e17-11eb-93bb-254fb5729b6e.png)

## Problem
There are several Project documents to create and maintain. As per 13485 and SDLC, documents
at key development phases must be captured and controlled – reviews conducted at input and
output of the phase (Design Input, Design Output, Design Validation etc) need to be captured
consistently and maintained. Some of the project data rarely change in every release, some may
change. During Audits, documents such as project plan, test plan, scope, design
input/out/verification phases, risk management and assessments, soup assessments are all
required to be produced and maintained for every project iteration.

## Features
1. Logging and signup feature with additional facilities for the admin
users.
1. Logging Project its related reviews and documents.
1. Project documents are created from a JSON template and also stored as
the JSON template in DB. The following documents can be created -
Project plan, test plan, impact analysis, and reviews.
1. Adding records for Team members and references. Team member's records
are used in assigning projects, reviews, and reviewed by fields in
various pages.

## Dependencies
`php-intl` and `php-zip` extensions should be installed for document generation.

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)