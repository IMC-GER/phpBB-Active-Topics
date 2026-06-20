# phpBB Active Topics

## Description
If you configure a forum as a category, the active topics of the sub-forums can be displayed there.
This extension allows you to define the position of the active topics and the number of topics displayed.
It adds the link to the forum from which the topic originated to the list of active topics.

[![Tests](https://github.com/IMC-GER/phpBB-Active-Topics/actions/workflows/tests.yml/badge.svg)](https://github.com/IMC-GER/phpBB-Active-Topics/actions/workflows/tests.yml)

#### Settings in Administration Control Panel
In "Forums" -> "Manage Forums" -> "Edit Forum"
- Display active topics above or below the category
- Number of topics per page
- Number of active topics pages
- Display parent forums in the active topics topic row

In "General" -> "Search settings" -> "Active Topics Settings"
- Number of days for the active topic search


## Screenshots
- [ACP](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/acp_130.png)
- [Forum](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/category_130.png)

## Requirements
- phpBB >= 3.3.18, < 4.0.0-dev  
- php >= 8.0.0  

## Installation
Copy the extension to `phpBB3/ext/imcger/activetopics`.
Go to "ACP" > "Customise" > "Manage extensions" and enable the "Active Topics" extension.

## Update
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for "Active Topics".
- Delete the `activetopics` folder from `phpBB3/ext/imcger/`.
- Copy the extension to `phpBB3/ext/imcger/activetopics`.
- Go to "ACP" > "Customise" > "Manage extensions" and enable the "Active Topics" extension.

## Changelog

### v1.3.0-b3 (21-06-2026)
- Added: Setting for active topics time range

### v1.3.0-b2 (18-05-2026)
- Changed: Display only parent forums that are subordinate to the current category
- Changed: jQuery was replaced with vanilla JS, because the page flickered when loading

### v1.3.0-b1 (15-05-2026)
- Added: Display active topics in multiple pages

### v1.2.0 (01-05-2026)
- Removed unused language class
- Improved sql-query for parent forums
- Renamed `activetopics.js` to `imcger_activetopics.js`
- Var names changed in acp listener
- Method name changed in main listener
- Use acp template event to insert forum settings
- Use `composer.json` requirements in `ext.php`
  - Added class `imcger_ext_requirements`
- Use event to get forum data in main listener

### v1.1.1 (13-10-2024)
- Minor change

### v1.1.0 (15-12-2023)
- Published

## Uninstallation
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for "Active Topics".
- To permanently uninstall, click `Delete Data`, then delete the `activetopics` folder from `phpBB3/ext/imcger/`.

## License
[GPLv2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
