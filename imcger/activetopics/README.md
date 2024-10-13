# phpBB Active Topics

## Description
If you configure a forum as a category, the active topics of the sub-forums can be displayed there.
This extension allows you to define the position of the active topics and the number of topics displayed.
It adds the link to the forum from which the topic originated to the list of active topics.

#### Settings in Administration Control Panel
In "Forums" -> "Manage Forums" -> "Edit Forum"
- Display active topics above the forums
- Topics per page

## Screenshots
- [ACP](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/acp_en.png)
- [Forum](https://raw.githubusercontent.com/IMC-GER/images/main/screenshots/activetopics/forum.png)

## Requirements
- phpBB 3.3.0 or higher

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
