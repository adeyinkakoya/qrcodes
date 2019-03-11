<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccount_historyRequest;
use App\Http\Requests\UpdateAccount_historyRequest;
use App\Repositories\Account_historyRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class Account_historyController extends AppBaseController
{
    /** @var  Account_historyRepository */
    private $accountHistoryRepository;

    public function __construct(Account_historyRepository $accountHistoryRepo)
    {
        $this->accountHistoryRepository = $accountHistoryRepo;
    }

    /**
     * Display a listing of the Account_history.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->accountHistoryRepository->pushCriteria(new RequestCriteria($request));
        $accountHistories = $this->accountHistoryRepository->all();

        return view('account_histories.index')
            ->with('accountHistories', $accountHistories);
    }

    /**
     * Show the form for creating a new Account_history.
     *
     * @return Response
     */
    public function create()
    {
        return view('account_histories.create');
    }

    /**
     * Store a newly created Account_history in storage.
     *
     * @param CreateAccount_historyRequest $request
     *
     * @return Response
     */
    public function store(CreateAccount_historyRequest $request)
    {
        $input = $request->all();

        $accountHistory = $this->accountHistoryRepository->create($input);

        Flash::success('Account History saved successfully.');

        return redirect(route('accountHistories.index'));
    }

    /**
     * Display the specified Account_history.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        return view('account_histories.show')->with('accountHistory', $accountHistory);
    }

    /**
     * Show the form for editing the specified Account_history.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        return view('account_histories.edit')->with('accountHistory', $accountHistory);
    }

    /**
     * Update the specified Account_history in storage.
     *
     * @param  int              $id
     * @param UpdateAccount_historyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAccount_historyRequest $request)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        $accountHistory = $this->accountHistoryRepository->update($request->all(), $id);

        Flash::success('Account History updated successfully.');

        return redirect(route('accountHistories.index'));
    }

    /**
     * Remove the specified Account_history from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $accountHistory = $this->accountHistoryRepository->findWithoutFail($id);

        if (empty($accountHistory)) {
            Flash::error('Account History not found');

            return redirect(route('accountHistories.index'));
        }

        $this->accountHistoryRepository->delete($id);

        Flash::success('Account History deleted successfully.');

        return redirect(route('accountHistories.index'));
    }
}
