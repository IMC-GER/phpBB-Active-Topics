# phpBB Active Topics

## Description
If you configure a forum as a category, the active topics of the sub-forums can be displayed there.
This extension allows you to define the position of the active topics and the number of topics displayed.
It adds the link to the forum from which the topic originated to the list of active topics.
The display options for Active Topics in Quick Links saved in a Cookie.

[![Tests](https://github.com/IMC-GER/phpBB-Active-Topics/actions/workflows/tests.yml/badge.svg)](https://github.com/IMC-GER/phpBB-Active-Topics/actions/workflows/tests.yml)

#### Settings in Administration Control Panel
In "Forums" -> "Manage Forums" -> "Edit Forum"
- Display active topics above or below the category
- Number of topics per page
- Number of active topics pages
- Display Forum or forum with there parent forums in the active topics topic row

## Screenshots
- [ACP](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/acp_130.png)
- [Forum](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/category_130.png)

## Requirements
- phpBB >= 3.3.16, < 4.0.0-dev  
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

## Uninstallation
- Navigate in the ACP to `Customise -> Manage extensions`.
- Click the `Disable` link for "Active Topics".
- To permanently uninstall, click `Delete Data`, then delete the `activetopics` folder from `phpBB3/ext/imcger/`.

## License
[GPLv2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html)
