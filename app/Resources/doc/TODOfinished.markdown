# GYGB - TODOfinished

## 1.2.1	
1. Steps
 - <del>revert to real count
 - <del>only show featured steps on community page
 - <del>no default story	
     - <del>affects map
 - <del>no default commitment
				
2. Misc
 - <del>merge  commitments and submissions
 - <del>batch spam
 - <del>batch feature
     - <del>remove spam actions
 - <del>header changes

## 1.1

1.	Share Buttons
 - use on form and notice after
	
2.	Google Map
 - community
     - center map
     - click markers
     - load from DB
 	 - clean up look
 - share a step	
     - place marker	
  	 - move
	 - ignore double click
	 - only one
	 - close
	 - store in DB	
	 - ignore scroll

3. My Steps
 - better login page
     - redirects?
 - counts
 - view steps
     - keep links
 - edit steps
     - map
     - step name
 - delete steps
     - actually delete	
 - unapproved steps + steps!!
     - add appropriate fields to step edit form
     - show status in unapproved somewhere
 - add commitments

4.	Find a Step		
 - explain process better	
 - make menu and headings less in the way...
     - use tabs from elsewhere for smaller menu
 - highlight share your own!
	
10.	Misc
 - remove repeat step
     - don't allow repeat steps
 - use user name if available
 - let admins sort resources
 - edit buttons on other content for admins
 - custom step label

## Bootstrap Transition
 - buttons
 - messages
 - forms
     - share a step
     - commit
 - font
 - text size
 - layout
 - headings
 - add to errorreportbundle
     - messages
 - add to UserBundle!
     - profile
	 - reset
	 - messages
	 - errors

## Post 1.0 Cleanup
1. clean controllers and views
2. clean css + templates
	 - split into multiple files
3. clean js!
	 - split into multiple files
4. make generic step list templates
5. Organization - Resource
	 - admin
	 - entity
	 - repo
	 - controllers
	 - templates
	 - css
6.	Repositories
10.	Misc
	 - re add sorting and counts!

## 1.0
1.	Menu
2.	Find a Step - 3
 - show commitment count
3.	Take a Step		
 - resources
     - group by category
	 - feature
	 - tinymce on backend
	 - change org to resources
	     - remove founder, sponsor
	 - logo
	     - backend
		 - fix size problem	
5.	Accounts - 8
 - submit step
     - hide name and e-mail if logged in
	 - use name and e-mail if logged in
	     - m-to-1
	 - send to register if not logged in
6.	Design - 5
7.	Admin - 5
 - upload logos
8.	Testing - 8
 a. Safarai
 b. Chrome
 c. old Firefox
 d. IE 8
 e. IE 7
 g. older safari
     - overflow on org blocks
10.	Misc - 3
 - JS message
 - ie6 message
 - errors
 - spool cron
 - backup git directories on server?
     - they are on github...
 - about line height
 - page subheadings
 - page messages
 - default story/commitment/count

## 0.9
1.	Admin
 - cleanup orgs	
     - remove old fields
     - remove old records
     - logos?
	     - fix path
2.	Content
 - resources from packet	
     - home page
	 - featured resources	
	 - make entity		

## 0.1
1.	Home
 - link path steps to step page			
 - simplify interface
	 - labels in fields
	 - autocomplete for what step
	 - what step starts with I
 - minimize steps to path submission
 - fix post problem
 - link recent steps blocks
2.	Steps
 - view all unique steps
	 - filter by category
	     - multiple categories
	 - sort by count, recent activity
		 - recent
		 - most recent date of a submission
	 - filter by savings
 - incorporate external links
	 - suggest steps that highlight orgs
 - search step text
 	 - LIKE %terms%				
	 - save searches
 - should the step page show anything about step submissions?
     - click on step, show more details
	     - description
		 - recent steps
		 - links?
		 - format better
 - check filters
	 - popular
 - step translation: use colon if step contains my, or similar words
3.	Administration
 -	step approval
    - db
	    - count confusing?
	- front end
        - mark as unapproved
		- only show approved
4.	Organizations		
 - move to own page
	- why join?
		- ads!
	- what do they have to do?
		- pay
		- share step
	- logo upload