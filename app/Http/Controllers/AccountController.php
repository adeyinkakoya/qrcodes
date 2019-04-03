<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Models\Account_history;
use Illuminate\Support\Facades\Auth;
use App\Repositories\AccountRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use Prettus\Repository\Criteria\RequestCriteria;

class AccountController extends AppBaseController
{
    /** @var  AccountRepository */
    private $accountRepository;

    public function __construct(AccountRepository $accountRepo)
    {
        $this->accountRepository = $accountRepo;
    }

    /**
     * Display a listing of the Account.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->accountRepository->pushCriteria(new RequestCriteria($request));
        $accounts = $this->accountRepository->all();

        return view('accounts.index')
            ->with('accounts', $accounts);
    }

    /**
     * Show the form for creating a new Account.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounts.create');
    }

    /**
     * Store a newly created Account in storage.
     *
     * @param CreateAccountRequest $request
     *
     * @return Response
     */
    public function store(CreateAccountRequest $request)
    {
        $input = $request->all();

        $account = $this->accountRepository->create($input);

        Flash::success('Account saved successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Display the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        //pull all account histories of this account ID
        $accountHistories = $account->account_histories;


        return view('accounts.show')
        ->with('account', $account)
        ->with('accountHistories', $accountHistories);
    }

    /**
     * Show the form for editing the specified Account.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        return view('accounts.edit')->with('account', $account);
    }

    /**
     * Update the specified Account in storage.
     *
     * @param  int              $id
     * @param UpdateAccountRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccountRequest $request)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $account = $this->accountRepository->update($request->all(), $id);

        Flash::success('Account updated successfully.');

        return redirect(route('accounts.index'));
    }

    /**
     * Remove the specified Account from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $account = $this->accountRepository->findWithoutFail($id);

        if (empty($account)) {
            Flash::error('Account not found');

            return redirect(route('accounts.index'));
        }

        $this->accountRepository->delete($id);

        Flash::success('Account deleted successfully.');

        return redirect(route('accounts.index'));
    }


    public function payout(Request $request)
    {
        // Get the account Id from the hidden form field
        // Check again if logged in user same as account user
        // Update applied for payout column in accounts table set to 1. Means i have applied for pay
        // Update paid column in accounts table set to 0. Means i have not been paid
        // Create a record in account histories table.
        // Success message ad redirect.
        
        $accountId = $request->input('accountID');
        
        // Account::find($accountId) or use account Repository
        $account = $this->accountRepository->findWithoutFail($accountId);
        // At this point the $account var contains the row for that particular Id so you can access all the row columns normally with $account->id, $account->user_id, $account->balance
        
        if (empty($account)) {
            Flash::error('Error. Please try again');

            return redirect()->back();
        }

        if(Auth::user()->id !== $account->user_id) {

            Flash::error('Unauthorized access');

            return redirect()->back();
        }

        Account::where('id', $account->id)->update([
            'applied_for_payout'=>1,
            'paid'=>0,
            'last_date_applied'=>Carbon::now()
        ]);

        // Use the Account_history Model. Import it
        Account_history::create([
            'account_id'=>$account->id,
            'user_id'=>$account->user_id,
            'message'=>'Request for payout made'
        ]);

        // Other tasks such as send mail , send sms etc

        Flash::success('REQUEST for payout was successful.');
        return redirect()->back();

        //return redirect(route('accounts.index'));
   

       
    }

    // This method is fully an admin function , carried out by admin.
    public function mark_as_paid(Request $request)
        {
        // Get the account Id from the hidden form field
        // Check if logged in user is Admin. 
        // Update applied for payout column in accounts table set to 0. reset the field back to 0
        // Update paid column in accounts table set to 1. Means payment has been made
        // Create a record in account histories table.
        // Success message ad redirect.
        
        $accountId = $request->input('accountID');
        
        // Account::find($accountId) or use account Repository
        $account = $this->accountRepository->findWithoutFail($accountId);

        if (empty($account)) {
            Flash::error('Error. Please try again');

            return redirect()->back();
        }

        // Check if youre not admin and sends you out
        if(Auth::user()->role_id > 2) {

            Flash::error('Unauthorized access');

            return redirect()->back();
        }

        Account::where('id', $account->id)->update([
            'applied_for_payout'=>'0',
            'paid'=>1,
            'last_date_paid'=>Carbon::now()
        ]);

        Account_history::create([
            'account_id'=>$account->id,
            'user_id'=>$account->user_id,
            'message'=>'Payment Completed Successfully'
        ]);

        
        // Other tasks such as send mail , send sms etc
        Flash::success('Request made successfully.');
        return redirect()->back();
        //return redirect(route('accounts.index'));
   

       
         }





}
