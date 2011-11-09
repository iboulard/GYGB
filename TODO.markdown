Get Your Greenback - TODO
======================================

when rolling out:
	a.	Locally
//		-	push bundles
	
//			- error
		
//			- useradmin
	
/			- admin
			
//			- user
	
		-	create bootstrap bundle
	
		-	push branch
	
		-	merge git branch

	b.	server
		-	git update GYGB
		
		-	update error/admin/user/admin2
	
		-	backup DB
		
		-	Update db
		
			- manually change Organization -> Resource where you can


	c.	ie Testing

	d. not urgent
		-	remove <p> from step descriptions
	
		-	set resource ranks

		-	transfer ranks
	
		-	Upload site map

		-	test logo uploads	
	
	
Issues
==============
	
	- fix remember me

	- fill out registration form after submission
	
	- what to do with filters when searching?

	- step model problem
	
		- add m2m field on admin
		
	- remove or fix + button on M2M tool
	
		- likely need a branch of SonataDoctrineOrm
			
		
Ideas
===========

	- Tell a story
			I think it would be more effective to ask more detailed questions to help them tell
			the story.  Ask a question and then give them a text box to respond.
			What did you do?  What obstacles did you overcome to do it? 
			Was it worth the effort?  Have you inspired anyone else by your step? - Katie B
	
			- optional after submission
	
	
	- Featured individuals / organizations
	
		- will come when coalition figures this piece out
		
		highlight photos, videos, text of community member doing it right
		
		- add to community page
		
		- add to home page


		
1.2
=========================
	1.	Organizations
	
		- sign up
	
			- logo
			
			- description (for ads)
			
				- use tinymce
				
		- share a step?
		
		- include coalition


#	2.	JS degradation

		- less sophisticate step filters
		
			- save old ones
		
	
#	3.	Facebook and Twitter

		- API integration?


#	4.	E-mail reminders

		- for commitments
		
		
#	5.	Audience

		- homeowner, renter, landlord, school, students, congregations

		- add to step form
		
		- add who/where filters to community page						

			- user/submission/commitment
			
				- who are you
				
				- where are you (map)
				
					=>g
						community
						
						- filter by who and where
			

						
#	6.	Share a Step
	
		- cancel selected step
		
		- better step selection dropdown
		
		- custom step
		
			- organization drop down

				- featured step


#	20.	Cleanup

		a.	Merge Organizations and Commitments
		
			- type
			- name
			- date
			- text
			- step
			
			- simplifies sorting, mysteps, ugly Step repo code
			
			- switch to eventList controller
			
				- add edit buttons
			



== Finished =========================

1.1
=============================

//	1.	Share Buttons

//		- use on form and notice after
		
//	2.	Google Map
	
//		- community
	
//			- center map

//			- click markers
	
//			- load from DB

//			- clean up look
		
//		- share a step
		
//			- map
			
//			- place marker
			
//				- move
	
//				- ignore double click
				
//				- only one
	
//				- close
				
//				- store in DB
				
//				- ignore scroll
	

//	3.	My Steps		
	
//		- better login page
		
//			- redirects?
	
//		- counts

//		- view steps
		
//			- keep links
		
//		- edit steps
		
//			- map
			
//			- step name
			
//		- delete steps
		
//			- actually delete	
		
//		- unapproved steps + steps!!
	
//			- add appropriate fields to step edit form
			
//			- show status in unapproved somewhere
	
//		- add commitments
		
		
//	4.	Find a Step	
		
//		- explain process better	

//		- make menu and headings less in the way...

//			- use tabs from elsewhere for smaller menu

//		- highlight share your own!

		
//	10.	Misc

//		- remove repeat step
		
//			- don't allow repeat steps
			
//		- use user name if available
	
//		- let admins sort resources

//		- edit buttons on other content for admins

//		- custom step label
		
Bootstrap Transition
================
//		- buttons
		
//		- messages
		
//		- forms
	
//			- share a step
			
//			- commit
	
//		- font
		
//		- text size
		
//		- layout
				
//		- headings

//		- add to errorreportbundle
		
//			- messages

//		- add to UserBundle!

//			- profile
			
//			- reset
			
//			- messages
			
//			- errors

Post 1.0 Cleanup
=================

//	1. clean controllers and views
	
	
//	2. clean css + templates
	
//		- split into multiple files
	
	
//	3. clean js!
	
//		- split into multiple files
	
	
//	4. make generic step list templates


//	5. Organization - Resource
	
//		- admin
		
//		- entity
		
//		- repo
		
//		- controllers

//		- templates
		
//		- css
	
//	6.	Repos!
	
//	10.	Misc
	
//		- re add sorting and counts!

1.0
=======================


//#	1.	Menu



//	2.	Find a Step - 3

//		- show commitment count
	
	
//	3.	Take a Step
				
//		- resources
			
//			- group by category

//			- feature

//			- tinymce on backend

//			- change org to resources
			
//				- remove founder, sponsor
				
//			- logo
			
//				- backend
				
//				- fix size problem
							

//	5.	Accounts - 8

//		- submit step
		
//			- hide name and e-mail if logged in
			
//			- use name and e-mail if logged in
			
//				- m-to-1
						
//			- send to register if not logged in
			
					
//	6.	Design - 5
	
//	7.	Admin - 5
	
//		- upload logos

//	8.	Testing - 8
	
//		a. Safarai
		
//		b. Chrome
		
//		c. old Firefox
		
//		d. IE 8
		
//		e. IE 7
		
//		g. older safari
		
//			- overflow on org blocks

//	10.	Misc - 3
		
//		- JS message
		
//		- ie6 message

//		- errors
		
//		- spool cron
		
//		- backup git directories on server?
		
//			- they are on github...
			
//		- about line height
		
//		- page subheadings
		
//		- page messages
		
//		- default story/commitment/count
		
0.9
=======================
//	1.	Admin
	
//		- cleanup orgs
		
//			- remove old fields
			
//			- remove old records
			
//			- logos?
	
//				- fix path
	
//	2.	Content
	
//		- resources from packet
		
//		- home page
		
//			- featured resources
			
//				- make entity
				
//					type home/take-a-step
//					resource

0.1
=======================

//	1.	Home
	
//		- link path steps to step page
						
//		- simplify interface
		
//			- labels in fields
			
//			- autocomplete for what step
			
//			- what step starts with I
		
//		- minimize steps to path submission
		
//		- fix post problem

//		- link recent steps blocks
		
		
//	2.	Steps
	
//		- view all unique steps
		
//			- filter by category
			
//				- multiple categories
			
//			- sort by count, recent activity
			
//				- recent
				
//					- most recent date of a submission
					
//			- filter by savings
			
//		- incorporate external links
	
//			- suggest steps that highlight orgs
	
//		- search step text
		
//				- LIKE %terms%				
			
//			- save searches
			
//		- should the step page show anything about step submissions?
		
/			- click on step, show more details
			
//				- description
				
//				- recent steps
				
//				- links?
				
//				- format better
				
	
//		- check filters
		
//			- popular
			
		
//		- step translation: use colon if step contains my, or similar words

	
//	3.	Administration
	
//		-	step approval
		
//			- db
			
//					- count confusing?
				
//			- front end
			
//				- mark as unapproved
				
//				- only show approved
	
		
//	4.	Organizations		
	
//		- move to own page
		
//			- why join?
			
//				- ads!
			
//			- what do they have to do?
			
//				- pay
				
//				- share step
			
			- give them account?
			
				- might as well
		
//		- logo upload
		
		- admin interface
		
			- add logos?