# Virl Config Generator (VCG)

VCG is a Laravel PHP artisan command to inject router configuration files into a .virl template.  In short, this will scan folders within the virl-configs directory and then scan the subfolders within that directory to get a list of "projects".  Next it will use the virl.base.virl file inside of the virl-configs directory as a template.  Then it will inject the config file with the corresponding node name into the proper place of the virl template and save the template to the file system.

## Requirements
  - PHP >= 5.5.9
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Mbstring PHP Extension
  - Tokenizer PHP Extension
  - Composer (https://getcomposer.org)

### OR
  - Vagrant
  - Virtual Box
  - Laravel Homestead (https://laravel.com/docs/master/homestead)

## Install
 - git clone https://github.com/rmclain/virl-config-generator.git
 - cd virl-config-generator
 - composer install

## Execute
To run the script simply use the built in artisan command
    `php artisian virl:generate {folder}`
Where {folder} is the directory of directories you wish to parse relative to the virl-configs folder.

## Example
An example file has been included to demonstrate this process. If we run the command `php artisian virl:generate ine-initial-sample`
Then this will, for example, map a node from our virl.base.virl file, in this case R1:

    <node name="R1" type="SIMPLE" subtype="IOSv" location="57,131">
        <interface id="0" name="GigabitEthernet0/1"/>
    </node>

Then it will pull all subfolders and grab virl-configs-ine-initial-sample/foundation-labs/lab1/R1.txt which is a configuration we pulled from the router.  R1.txt will then be injected into a new .virl file and saved to the file system.

