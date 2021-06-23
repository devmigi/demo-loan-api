
## Loan API Project

### Installation
This project can be easily started using [Laravel sail](https://laravel.com/docs/8.x/sail#starting-and-stopping-sail) 

\
**Setup steps**:
- clone git repo to local
- `cd` to downloaded folder
- run `sail up` command
- run db migrations with seed `sail artisan migrate:fresh --seed`
- use postman collection(from repo or [this link](https://raw.githubusercontent.com/devmigi/demo-loan-api/master/loan_api_postman_collection.json)) to start using APIs


###API Endpoints
\
**Public APIs** (without authentication):
 - POST - /api/v1/register (Register API)
 - POST - /api/v1/login (Login API)
 
 
 - GET -  /api/v1/interest-rate (Get Interest rates for different loan tenure) 
 
 \
 **Private APIs** (with authentication header bearer token):
  - GET -  /api/v1/profile (Logout) 


  - GET  - /api/v1/loans (Get all loan applications of current user)
  - POST - /api/v1/loans (Apply for a new Loan)
  
  
  - GET  - /api/v1/repayments (Get all repayments schedule with loan detail)
  - POST - /api/v1/repayments (Repay pending Repayment/EMI)
  
 \
 **Admin Private APIs** (with authentication header bearer token):
   - GET -   /api/v1/admin/loans/{{loan_id}} (Get a loan detail) 
   - POST -  /api/v1/admin/loans/{{loan_id}} (Approve/Reject a loan) 
 
\
 *Note: Role and Permissions feature has not implemented.*


### Postman Collection
[https://raw.githubusercontent.com/devmigi/demo-loan-api/master/loan_api_postman_collection.json](https://raw.githubusercontent.com/devmigi/demo-loan-api/master/loan_api_postman_collection.json)



---

##Laravel Code Challenge
> Your task is to build a mini-aspire API:\
It is an app that allows authenticated users to go through a loan application. It doesn’t have to contain too many fields, but at least “amount
required” and “loan term.” **All the loans will be assumed to have a “weekly” repayment frequency.**\
After the loan is approved, the user must be able to submit the weekly loan repayments. It can be a simplified repay functionality, which won’t
need to check if the dates are correct but will just set the weekly amount to be repaid.

\
**Notes**:
- Build fully functional REST API without any UI
- README.md should contain all the information that the reviewers need to run and use the app
- Write code with your teammates in mind: readable, easy to review & understand
- The quality of the tests is one of the key factors
- Include brief documentation for the project: the choices you made and why

\
**Nice-to-have**:
- script to install the app in one go
- postman collection/openAPI document for the API
- The complete project should be shared with us as a public GitHub/Bitbucket/GitLab repo
