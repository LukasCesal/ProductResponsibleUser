# ProductResponsibleUser
Adobe commerce module for user responsible for product of catalog

# Magento2 Module Product Responsible User

This module is intended to be used as main module for main functionality of Responsible User feature.

## Usage of repository:

Magento module with vendor `Aiti`.

### Composer

Composer package name should be `aiti/module-responsible-user`

### `app/code`

Into `app/code` please clone `app/code/Aiti`, the final path will be: `app/code/Aiti/ProductResponsibleUser`


### Docs
- https://devdocs.magento.com/guides/v2.4
- https://www.mageplaza.com/magento-2-module-development/
- https://mage2gen.com
- Reference modules: `module-inventory`, `module-user`, `module-catalog`

## Task description
Your task is to create complete management of Responsible Users for products. Every product has one
responsible user but a user can have n products. Every responsible user is working in a department.

Acceptance criteria
- User can see list of responsible users
- User can create, edit, delete and mass delete responsible users
- User can assign responsible user to a product
- User can add/remove a department
- User can get, create and delete user through REST API

### Basic stuff
Learn how init a module. Create `composer.json`, `registration.php` and `etc/module.xml`  

Create database table with columns *user_id*, *firstname*, *lastname*, *department* (int or varchar) and *created_at*.  

Use `etc/db_schema.xml` and `etc/db_schema_whitelist.json` to create a table. You should have it done
before you install the module with `setup:upgrade`.  

Don't forget to put `declare(strict_types=1)` at the beggining of every file.

### API
Create all interfaces in ProductResponsibleUserApi module, folder Api.  
ProductResponsibleUserInterface goes to Api/Data folder, ProductResponsibleUserRepositoryInterface in Api folder.  
Model interface contains get/set methods, repository should have `getById`, `getList`, `save` and `deleteById`.  
Don't forget to use type hints and annotations.

To work with model and database you should use ONLY interfaces.  
Always use ProductResponsibleUserInterface, ProductResponsibleUserRepositoryInterface of ProductResponsibleUserInterfaceFactory.


### Model
You should use the Repository approach. Create a model file that implements API interface. Create a resource model and collection.
Create a repository file and implement methods. You will use resource model in this one. You should cover NoSuchEntityException and other exceptions.

Connect interfaces and implementations using `di.xml`

**TIP:** No need to create `ProductResponsibleUserInterfaceSearchResults` or `ProductResponsibleUserInterfaceSearchResultsFactory`, just make
a reference and Magento creates it for you. You will find out all Factory files are generated automatically.

You can generate all files with command `setup:di:compile`.

### AdminUi
You will be adding new departments in Stores/Configuration. Create a whole new section Aiti with one option Responsible Users.  
For departments use `dynamic rows` with columns *name*, *external* (yes/no) and *delete button*. You can save ID of the row defaultly or create own hidden IDs.
Default way is a string, you can create numerical IDs. It's up to you. Create your table column accordingly.  

For grid use listing component with columns User ID, Firstname, Lastname, Department, Created and Actions with Edit button. Or you can make the whole row clickable.  
Create basic edit form with name, lastname and select box for departments.  
User should be able to go back, delete and save user from the edit form. Put buttons for every of these operations. Make Save user a primary button.

Create a `routes.xml` file.

Use ui_components and DataProviders for all UI components. Layout files only reference ui components. Layout file name should reference a path. RouteID_FolderWithCotrollers_Controller. 
For example: `responsible_users_users_edit.xml`.

Create controllers for Index, Edit, Save, New, Delete and MassDelete.

For products create an EAV attribute and make it visible in General tab.

### Webapi
Every method from Repository should be accessible with REST API client. Create a `webapi.xml` file with all methods. Create at least one ACL to restrict access to commands.
No methods should be accessible without an OAuth token. Make one query to generate a token.
For testing you can use Postman or curl command using command line.

