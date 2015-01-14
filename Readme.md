Http Verb Extraction
=================


Introduction
---
`In a nutshell`, what this module does, is extracting each http verbs (as I call them), such as `create` (for posting on collection), `delete`, `fetchAll`, `deleteList`, ... to their own classes.

Well, It's been awhile I've been hacking around apigility and recently I chose to use it on a project we've started. The thing I don't like about it and which this module is kind of trying to address it is that in Resource classes we have lots of methods, each belongs to a http method (http verb) for either a collection or entity. Methods like `create`, `delete`, `fetchAll`, ... .

What it seems to me is like a controller with lots of actions in it. Which I believe in one action per controller personally, and the issue as you might have gussed by now arises here. That I'm not definelty going to invoke more than one action at a time. But the objects those methods depend on has to get passed to the respective class so that it can get to work whenever it has to.

To be clear, the issue I am facing is that, I have to pass lots of objects to the class so that some of them may be called by some of the methods in it. Which as it sounds it is breaking Single Responsibility principle as well. That the respective class has may jobs to do.

To be fair, I need to mention that I've seen some people pass the class a mapper object which is one object only. But to me, it feels like delegating the problem to someone else, another object, and does not seem like getting rid of the problem at all.

`What this module is aiming for, is to solve this issue.`

Unfortunately I'm not completly familiar with apigility's internals so that I could not come up with a better solution. I mean there are some stuff that I do not like about this module and could be solved but it would need to change apigility as well which is not what I want for now, or that they may be solve in a better ways with apigility's current status, which I am not familiar.

I will mention those issues but for now it's enought talking (writing). Lets see what we've got here.


Installation
---
First you need to either download this module manually, using git or by composer.
It is recommended to use composer, but the choice is yours.

If your are using composer, it will download the module to vendor/ directory by default.
If you are downloading manually, or cloning it using git, then you need to place it under vendor/ directory as composer does.

Then you need to add `HttpVerbExtraction` to your `config/application.config.php` file under 'modules' key.

+ For installing using composer you need to run this command in your project's root directory: 
    > `composer require "baghayi/http-verb-extraction:dev-master"`

+ If you want to directly clone it using git then you need to run this command under vendor/ (or wherever your modules will be loaded from) directory:
    > `git clone https://github.com/baghayi/HttpVerbExtraction`

+ You can also download module in a zip file by clicking on 'Download ZIP' button or use this URL, then move it to vendor/ directory then unzip it:
    > `https://github.com/baghayi/HttpVerbExtraction/archive/master.zip`

Now you are ready to go.