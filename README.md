# SimplyMarkdown

A very simple way to handle Markdown content on your website

This package can be used to render the markdown content on your website. For example, you can write blog posts on your blog using markdown and parse it using SimplyMarkdown. It will return you the markdown content as html as well as the meta data on your markdown file tht you set, such as title, slug, description, etc.

The below example will illustrate.

## **Example 1: getting the contents of a markdown post**:

_sample-post.md_:

```md
---
title: This is a sample title
description: This is a description
cover_image: /path/to/image.png
slug: sample-post
---

This is the body content of the blog post.

```

_using the parser in your app_:

```php
<?php

use SimplyDi\SimplyMarkdown\MdParser;

require_once '../vendor/autoload.php';

$parser = new MdParser(
    __DIR__ . '/md/'
);

$output = $parser->getFileContent("sample-post");

echo "<pre>";
print_r($output);
```

**Output**:

```html
Array
(
    [title] => This is a sample title
    [description] => This is a description
    [cover_image] => /path/to/image.png
    [slug] => sample-post
    [content] => 

This is the body content of the blog post.


)

```

A you can see, you get an array of meta data you passed as Yaml in the markdown file as well as the content you wrote.