# SlugField Plugin for OctoberCMS
SlugField is a form widget plugin for OctoberCMS. It provides a user-friendly way to generate URL slugs for your content.

## Features
* Easy to use: Simply add the SlugField widget to your form and start generating slugs.
* URL validation: SlugField ensures that the generated slug is a valid URL.
* Customizable: You can easily customize the appearance of the SlugField widget with CSS.
* Dynamic page linking: You can use the `page('name', 'param')` function to generate a link to a specific OctoberCMS page.
## Usage
To use the SlugField widget in your form, add it to your fields.yaml file:
```yaml
fields:
    title:
      label: title
      type: text
    slug:
        label: Slug
        type: slugfield
        link: 'https://yourdomain.com'
        preset:
          type: slug
          field: title
```
The link attribute is optional. If provided, it will be used as the base URL for the generated slug preview.

You can also use the `page('name', 'param')` function as the value of the link attribute to generate a link to a specific OctoberCMS page. For example:
```yaml
fields:
    title:
      label: title
      type: text
    slug:
        label: Slug
        type: slugfield
        link: page('blog', 'slug', 'url_param_1':'colum_name_1', 'url_param_2':'colum_name_2')
        preset:
          type: slug
          field: title
```
In this example, the `page('blog', 'slug', 'url_param_1':'colum_name_1', 'url_param_2':'colum_name_2')` function will generate a link to the 'blog' page with the slug as a parameter.

You can add as many URL parameters as you like, targeting the columns in your template by chaining `'url_param_1':'colum_name_1'` inside the `page()` function.

Please note: Relationships are not yet taken into account.

The slug is not saved directly when it is regenerated, so it is necessary to remember to save the form to keep it.

## Contributing
Contributions are welcome! Please submit a pull request with any enhancements, fixes, or features.

## License
This project is licensed under the MIT License. See the LICENSE file for details.


