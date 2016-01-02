## Get the excerpt of your content

![Spress 2 ready](https://img.shields.io/badge/Spress%202-ready-brightgreen.svg)

You can use *more tag* to get a excerpt of your content like blog entries.

**This plugin requires Spress >= 2.0**. If you are using Spress 1.x, go to [1.0.1](https://github.com/yosymfony/Spress-plugin-more-tag/tree/v1.0.1) version of the plugin.


### How to install?

Go to your Spress site and add the following to your `composer.json` and run 
`composer update`:

```json
"require": {
    "yosymfony/spress-plugin-more-tag": "2.0.*"
}
```

### How to use?

In Markdown syntax you can use `--more--` or `--more <your-more-label>--` 
like `--more More information-- to get a excerpt of your blog entries. The content
located before of *more tag* will be a excerpt. The more tag require a new line
at the end:

This is **wrong**:

```markdown
Your main text
--more-- Explain text
```

**The template side**

This plugin provides some Twig filters and one test to handle excerpt concern:

* `excerpt` filter gets the excerpt of content. `{{ post.content | excerpt }}`.
* `content` filter gets the content without more tag text. `{{ post.content | content }}`.
* `excerpt_label` filter gets the label associated to more tag text.
* `with_excerpt` test lets you check if a variable has the more tag text.

#### Examples

```markdown
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

```markdown
---
layout: default
---

Hello and welcome to **Spress, a static site generator capable to generate
blogs sites**.

--more More information--

Your post can be write in Markdown and your templates are
writing with [Twig](http://twig.sensiolabs.org/documentation).
```
