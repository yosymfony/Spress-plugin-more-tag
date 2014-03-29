## Get the excerpt of your blog entries

You can use *more tag* to get a excerpt of your blog entries.

**Require**:
* Spress >= 1.0.2

### How to install?

Go to your Spress site and add the following to your `composer.json` and run 
`composer update`:

```
"require": {
    "yosymfony/spress-plugin-more-tag": "~1.0"
}
```

### How to use?

In Markdown syntax you can use `--more--` or `--more <your-more-label>--` 
like `--more More information-- to get a excerpt of your blog entries. The content
located before of *more tag* will be a excerpt. The more tag require a new line
at the end:

This is **wrong**:

```
Your main text
--more-- Explain text
```

**How to use in the template?**

Two additional variables are availables only in pagination time (**pagination template**):

* `page.excerpt`: The excerpt content.
* `page.excerpt_label`: The value of <your-more-label>.

In your pagination template:

```
{% for post in paginator.posts %}
    {{ post.excerpt }}
    <a href="{{ site.url }}{{ post.url }}">{{ post.excerpt_label }}</a>
{% endfor %}
```

If you have a page like RSS or similar, you can access to posts excerpt using `site.posts_excerpts`:

```
{% for post in site.posts | slice(0, site.max_item, true) %}
    <item>
        <title>{{ post.title }}</title>
        <description><![CDATA[{{ site.posts_excerpts[post.id].value }}]]></description>
        <link>{{ site.url }}{{ post.url }}</link>
        <pubDate>{{ post.date | date("D, d M Y H:i:s O") }}</pubDate>
        <guid>{{ site.url }}{{ post.url }}</guid>
    </item>
{% endfor %}
```

#### Examples
```
---
layout: default
---

Hello and welcome to **Spress, a static site generator capable to generate
blogs sites**.

--more--

Your post can be write in Markdown and your templates are
writing with [Twig](http://twig.sensiolabs.org/documentation).
```

Example 2:

```
---
layout: default
---

Hello and welcome to **Spress, a static site generator capable to generate
blogs sites**.

--more More information--

Your post can be write in Markdown and your templates are
writing with [Twig](http://twig.sensiolabs.org/documentation).
```