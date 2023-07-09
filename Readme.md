# [WordPress Theme - Understrap-child]

This is a fork of wp understrap-child theme.
Support:

- singleton pattern
- custom block pattern starter kit
- custom post starter kit
- languages starter kit
- slick.js slider js library
- Google font signika-negative

With other understrap build in features:

- Combines Underscore’s PHP/JS files and Bootstrap’s HTML/CSS/JS.
- Comes with Bootstrap v5 Sass source files and additional .scss files. Nicely sorted and ready to add your own variables and customize the Bootstrap variables.
- Uses sass and postCSS to handle compiling all of the styles into one style sheet. The theme also includes rollup.js to handle javascript compilation and minification.
- Uses a single minified CSS file for all the basic stuff.
- Font Awesome integration (v4.7.0)
- Jetpack ready
- WooCommerce support
- Contact Form 7 support
- Translation ready

## Installation

```bash
cd wp-content/theme/
git clone https://github.com/leorsida/understrap-child .
cd understrap-child
npm install
```

## Development

Override bootstrap variables on _child_theme_variables.scss eg: $primary: #ff6600;
Write your custom style on _child_theme.scss
Write your custom js inside custom-javascript.js

```bash
npm run watch-bs
```

## Distribute

```bash
npm run dist
```

This command creates a /dist/ directory inside your child theme and populates it with a distributable version of your child theme. This version does not include any development files or features, such as the package.json and the entire /src/ folder, meaning that another user wouldn't be able to modify and rebuild the stylesheets or javascript files.

By default, the /dist/ is included in the .gitignore file and is not version controlled.

```bash
npm run dist-clean
```

This command deletes the newly-created /dist directory.