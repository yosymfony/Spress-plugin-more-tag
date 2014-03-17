## Get the excerpt of your posts

Using *more tag* to get a excerpt of **your posts** content.

**Require**:
* Spress >= 1.0.1

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
like `--more More information-- to get a excerpt of your content. The content
located before of *more tag* will be a excerpt. The more tag require a new line
at the end:

This is wrong:
```
Your main text
--more-- Explain text
```

**How to use in a template?**
Two additional variables is availables:

* page.excerpt: The excerpt content.
* page.excerpt_label: The value of <your-more-label>.

In your pagination template:
```
{% for post in paginator.posts %}
    {{ post.excerpt }}
    <a href="{{ site.url }}{{ post.url }}">{{ post.excerpt_label }}</a>
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