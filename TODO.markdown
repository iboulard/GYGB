Get Your Greenback - TODO
======================================

Issues
==============
	
	- fix remember me
		
	- fill out registration form after submission
	
	- what to do with filters when searching?

	- step model problem
	
		- add m2m field on admin
		
	- remove or fix + button on M2M tool
	
		- likely need a branch of SonataDoctrineOrm
			
	- step submission deletion
	
		- cascade properly
		
		
Ideas
===========

	- Tell a story
			I think it would be more effective to ask more detailed questions to help them tell
			the story.  Ask a question and then give them a text box to respond.
			What did you do?  What obstacles did you overcome to do it? 
			Was it worth the effort?  Have you inspired anyone else by your step? - Katie B
	
			- optional after submission?
	
	
	- Featured individuals / organizations
	
		- will come when campaign figures this piece out
		
		highlight photos, videos, text of community member doing it right
		
		- add to community page
		
		- add to home page

	
	- facebook/twitter api integration?

		- not worth the time right now

	- incorporate organizations?
	
		- need help from others to figure out the details
	
1.2
==========================

//	- batch spam
	
//	- batch feature
	
//		- remove spam actions
	
//	- header changes
	
	1.	Steps
	
		a. revert to real count
		
//		b. only show featured steps on community page
	
		c. add new steps
		
			- what to use for titles?
			
//		d. no default story
	
//			- affects map
	
//			- no defaualt commitment
	
			
			
	
	2.	Videos
	
		- Community
		
			- new tab, default tab
			
				- where to put step counts?
			
			- browse
			
			- view video page?
			
			- vote on videos?
			
			- awards? prizes?
			
		- Share
		
			- update share process
			
				- text OR video
				
			
			- upload
			
				- should host on youtube, but never have users go to youtube
				
					- can cover this, except for uploads
					
		- highlight on home page
				
	
1.3
=========================
		
		
#	1.	E-mail reminders

		- for commitments
		
		
#	2.	Audience

		- homeowner, renter, landlord, school, students, congregations

		- add to step form
		
		- add who/where filters to community page						

			- user/submission/commitment
			
				- who are you
				
				- where are you (map)
				
					=>g
						community
						
						- filter by who and where
				
#	3.	Share a Step
	
		- cancel selected step
		
		- better step selection dropdown
		
		- custom step
		
			- organization drop down

				- featured step
				
				
				
#	4.	Revamp "featured content" - resources and steps featured on homepage / resource guide

		- confusing on admin end, easier to just mark a step or resource as featured
	
	
	
Nice to Have	
==============================================
#	1.	JS degradation

		- less sophisticate step filters
		
			- save old ones


Cleanup
=============================
		a.	Merge Organizations and Commitments
		
			- NOTE: wait until it feels like we will stick with commitments
			
				- pros of commitments:
				
					- engages visitors - most haven't taken a step yet
					
					- gives the "take a step" piece of the three step (find/take/share) process some
						substance
					
				- cons:
				
					- confusings to manage two ideas, "steps taken", "commitments made"
					
						- can make this clearer
		
			- type
			- name
			- date
			- text
			- step
			
			- simplifies sorting, mysteps, ugly Step repo code
			
			- switch to eventList controller
			
				- add edit buttons
				
				
		b.	REVERT to dynamic step counts!
		
			- only doing it this way because it made some kind of sorting hard...?
			
		
