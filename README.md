# mm_minimizableSections
A widget for ManagerManager plugin that allows one, few or all sections to be minimizable on the document edit page.
Can significantly reduce the space occupied on the screen, which is useful in the case of using a large number of TV parameters, 
especially when using multiparameters \(see. [mm_ddMultipleFields](http://code.divandesign.biz/modx/mm_ddmultiplefields/)\).

## Install
Copy folder mm_minimizableSections to __/assets/plungins/managermanager/widgets/__.

## Use
Read this documentation of [ManagerManager](http://code.divandesign.biz/modx/managermanager).

### Parameters
 - **fields**     - The id(s) of the sections this should apply to. Use '*' for apply to all.
 - **roles**      - The roles that the widget is applied to (when this parameter is empty then widget is applied to the all roles).
 - **templates**  - Id of the templates to which this widget is applied (when this parameter is empty then widget is applied to the all templates).
 - **minimized**  - The id(s) of the sections this should be minimized by default. Use '*' for apply to all.

To specify multiple values, each parameter can be set separated by commas.

## Examples

Apply to all sections for all roles and templates
```
mm_minimizableSections('*');
```
Apply to the content and Template Variables sections for users with role "1" editing the documents with the template ID equals "3"
```
mm_minimizableSections('content,tvs', '1', '3');
```
Apply to all sections and set minimized Template variables and photos sections by default
```
mm_minimizableSections('*','','','tvs,photos');
```
