<?php

namespace App\Services;

abstract class Pandoc
{
    public static $inputFormats = [
        "commonmark", // (CommonMark Markdown)
        "creole", // (Creole 1.0)
        "docbook", // (DocBook)
        "docx", // (Word docx)
        "dokuwiki", // (DokuWiki markup)
        "epub", // (EPUB)
        "fb2", // (FictionBook2 e-book)
        "gfm", // (GitHub-Flavored Markdown), or the deprecated and less accurate markdown_github; use markdown_github only if you need extensions not supported in gfm.
        "haddock", // (Haddock markup)
        "html", // (HTML)
        "ipynb", // (Jupyter notebook)
        "jats", // (JATS XML)
        "json", // (JSON version of native AST)
        "latex", // (LaTeX)
        "markdown", // (Pandoc’s Markdown)
        "markdown_mmd", // (MultiMarkdown)
        "markdown_phpextra", // (PHP Markdown Extra)
        "markdown_strict", // (original unextended Markdown)
        "mediawiki", // (MediaWiki markup)
        "man", // (roff man)
        "muse", // (Muse)
        "native", // (native Haskell)
        "odt", // (ODT)
        "opml", // (OPML)
        "org", // (Emacs Org mode)
        "rst", // (reStructuredText)
        "t2t", // (txt2tags)
        "textile", // (Textile)
        "tikiwiki", // (TikiWiki markup)
        "twiki", // (TWiki markup)
        "vimwiki", // (Vimwiki)
    ];

    public static $outputFormats = [
        "asciidoc", // (AsciiDoc) or asciidoctor (AsciiDoctor)
        "beamer", // (LaTeX beamer slide show)
        "commonmark", // (CommonMark Markdown)
        "context", // (ConTeXt)
        "docbook", // or docbook4 (DocBook 4)
        "docbook5", // (DocBook 5)
        "docx", // (Word docx)
        "dokuwiki", // (DokuWiki markup)
        "epub", // or epub3 (EPUB v3 book)
        "epub2", // (EPUB v2)
        "fb2", // (FictionBook2 e-book)
        "gfm", // (GitHub-Flavored Markdown), or the deprecated and less accurate markdown_github; use markdown_github only if you need extensions not supported in gfm.
        "haddock", // (Haddock markup)
        "html", // or html5 (HTML, i.e. HTML5/XHTML polyglot markup)
        "html4", // (XHTML 1.0 Transitional)
        "icml", // (InDesign ICML)
        "ipynb", // (Jupyter notebook)
        "jats", // (JATS XML)
        "jira", // (Jira wiki markup)
        "json", // (JSON version of native AST)
        "latex", // (LaTeX)
        "man", // (roff man)
        "markdown", // (Pandoc’s Markdown)
        "markdown_mmd", // (MultiMarkdown)
        "markdown_phpextra", // (PHP Markdown Extra)
        "markdown_strict", // (original unextended Markdown)
        "mediawiki", // (MediaWiki markup)
        "ms", // (roff ms)
        "muse", // (Muse),
        "native", // (native Haskell),
        "odt", // (OpenOffice text document)
        "opml", // (OPML)
        "opendocument", // (OpenDocument)
        "org", // (Emacs Org mode)
        "plain", // (plain text),
        "pptx", // (PowerPoint slide show)
        "rst", // (reStructuredText)
        "rtf", // (Rich Text Format)
        "texinfo", // (GNU Texinfo)
        "textile", // (Textile)
        "slideous", // (Slideous HTML and JavaScript slide show)
        "slidy", // (Slidy HTML and JavaScript slide show)
        "dzslides", // (DZSlides HTML5 + JavaScript slide show),
        "revealjs", // (reveal.js HTML5 + JavaScript slide show)
        "s5", // (S5 HTML and JavaScript slide show)
        "tei", // (TEI Simple)
        "xwiki", // (XWiki markup)
        "zimwiki", // (ZimWiki markup)
    ];

    public static function convert($file, $from, $to)
    {
        $inputFile = storage_path('app/public/') . $file;
        $outputFile = storage_path('app/public/') . explode('.', $file)[0] . '.' . $to;

        // Example: pandoc test1.md -f markdown -t html -s -o test1.html
        $command = sprintf("pandoc %s -f %s -t %s -s -o %s", $inputFile, $from, $to, $outputFile);
        exec(escapeshellcmd($command), $cmdOutput);
        return $cmdOutput;
    }
}
