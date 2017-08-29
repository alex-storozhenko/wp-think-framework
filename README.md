# wp-think-framework

WordPress Think Framework is a developer-oriented library that gives you the ability to quickly and easily create incredible websites with WordPress. This is an extensible framework for developing WordPress themes. Based on the WordPress API.

#### Server Requirements:

1. PHP 5.4 or greater (Recommended 7.*)
2. WordPress 4.7 or later

### Installation tutorial:

1. Download framework from Github repo - https://github.com/alex-storojenko/wp-think-framework
2. Extract and copy folder with files of framework to theme dir({wp-installation-folder}/wp-content/themes/{your-theme-directory})
3. OR You can copy folder with framework somewhere.
4. Include wp-think-framework.php to functions.php of your theme(require_once {path to wp-think-framework_root_dir}/wp-think-framework.php')
5. Create instance of framework - Think_Framework::get_instance() in functions.php of your current theme
6. Create something amazing