Get Your Greenback - TODO
=========================


#	000. Meeting Changes

//	z. step cat filters for recent
	
//	x. popular filter

//	z. form submissions
	
		
	
//	z. header messages... POST?

//	a. home

//		- Commit your organization
		
//			- link instaed of button
			
//			- logo
			
//		- name problem with two forms

//		- logos off screen
		
//		- swap about with recent steps
		
//		- category names in blocks
		
	
//	b. Steps
	
//		- options border
		
//		- menu?
		
	
//	c. Static Home
	
//		- fix
		
	d. upload to server
	
		- add to git
		
		- add domain
		
	e.	browser test	
	
	
	
#	x.	incomplete from design weekend

		- logo upload
		
		- double forms on home page: avoid having to add hidden fields on eacah

#	00.

		-  StepRepository, line 90 order by count of steps:
			SELECT Step.id, step, StepSubmission.id, name FROM Step JOIN StepSubmission WHERE Step.id = StepSubmission.step_id Group By Step.id ORDER BY count(Step.id) DESC
		
		- step translation: use colon if step contains my, or similar words

#	0.	Users
	
		- anyone can submit step: name, step, category, savings
					
		- can also ask for e-mail to create account
		
			- send e-mail to have them set a password?
			
		- users can view their steps
		
		- save new steps to session and display them during session
		
			- only display approved steps in lists
			
			- include all steps in counts (simpler, no one will count)


#	1.	Home
	
//		- link path steps to step page

			- link recent steps?
				
				- would rather they see more, but would be confusing
		
		- incorporate new user and step fields
		
		- simplify interface
		
			- labels in fields
			
//			- autocomplete for what step
			
//			- what step starts with I
		
		- minimize steps to path submission
		
		- more information
		
		- $$$ saved graph
		
		- fix post problem
		
		
#	2.	Steps
	
//		- view all unique steps
		
//			- filter by category
			
//				- multiple categories
			
//			- sort by count, recent activity
			
//				- recent
				
//					- most recent date of a submission
					
//			- filter by savings
			
		- incorporate external links
	
			- suggest steps that highlight orgs
	
//		- search step text
		
//				- LIKE %terms%				
			
//			- save searches
			
		- should the step page show anything about step submissions?
		
			- click on step, show more details
			
				- show resources
				
				- show recent submissions

					- include user's e-mails if they allow it?
			
			- handle bigger steps
		
#	3.	Administration
	
		-	step approval
		
			- db
			
				- approval interface
				
					- finish approve action
					
					- batch approve action
					
//					- count confusing?
				
			- front end
			
//				- mark as unapproved
				
//				- only show approved
				
				- show from session
				
					- store in session
					
					- add session steps to recent steps, step list results, and counts?
		
		-	basic steps
		
		-	showcased steps
		
		
#	4.	Degradation
	
		- make sure everything works with javascript