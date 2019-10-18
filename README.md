# Moderated topic issue suffixes

This might not be the most common issue, but we needed to link forum topics to a gitlab issue and this is the extension I wrote for it.  
The extension is not limited to gitlab, though, it can be used for all platforms that have a URL structure that allows to add the issue ID at the end of it.  
If you would use it for any reason, but you have questions, feel free to ask or open an issue about it.  

## Install

1. Copy the content of this repo to `ext/nockiro/modissuesuffix`
2. Navigate in the ACP to `Customise -> Manage extensions` and enable the extension
3. Set the base URI to your issues (e.g. https://git.example.com/sampleProject/issues/) in the ACP (`Extensions -> ModSuffix Plugin Settings`)


## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Moderated topic issue suffixes` under the Enabled Extensions list, and click its `Disable` link.
3. For a complete uninstall, click `Delete Data` and delete the `/ext/nockiro/modissuesuffix` directory.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)
