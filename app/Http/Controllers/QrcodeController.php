<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Illuminate\Http\Request;
//use LaravelQRCode\Facades\QRCode;
use Illuminate\Support\Facades\Auth;
use App\Models\Qrcode as QrcodeModel;
use App\Repositories\QrcodeRepository;
use App\Http\Requests\CreateQrcodeRequest;
use App\Http\Requests\UpdateQrcodeRequest;
use App\Http\Controllers\AppBaseController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Prettus\Repository\Criteria\RequestCriteria;

class QrcodeController extends AppBaseController
{
   
    /** @var  QrcodeRepository */
    private $qrcodeRepository;

    public function __construct(QrcodeRepository $qrcodeRepo)
    {
        $this->qrcodeRepository = $qrcodeRepo;
    }
   
    /**
     * Display a listing of the Qrcode.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->qrcodeRepository->pushCriteria(new RequestCriteria($request));
        $qrcodes = $this->qrcodeRepository->all();

        return view('qrcodes.index')
            ->with('qrcodes', $qrcodes);
    }

    /**
     * Show the form for creating a new Qrcode.
     *
     * @return Response
     */
    public function create()
    {
        return view('qrcodes.create');
    }

    /**
     * Store a newly created Qrcode in storage.
     *
     * @param CreateQrcodeRequest $request
     *
     * @return Response
     */
    public function store(CreateQrcodeRequest $request)
    {
        // Get all the submitted form data
        $input = $request->all();
        //Create the record
        $qrcode = $this->qrcodeRepository->create($input);

        // create the qrcode file-img path, use the qrcodes table autoincrement field to make each file name unique.
        $file = 'generated_qrcodes/'.$qrcode->id.'.png';

        // Call the Qrcode generator package. Dont forget to import the class namespace

        $newQrcode=QrCode::format('png')->size(400)->generate('Make me into a QrCode!', $file);
       //$newQrcode=QRCode::text('message')->setSize(4)->setMargin(2)->setOutfile($file)->png();
       
       //Update the received data array with the qrcode path, if the new Qr code has been generated and saved to the file path 
       $input['qrcode_path']=$file;
            
       //Get thesame id of the inserted record and update the column qrcode_path.
       //Select all from Qrcode table where id is the earlier id in $input and update the table with path
       $updatecolumn= QrcodeModel::where('id',$qrcode->id)->update(['qrcode_path'=>$input['qrcode_path']]);
        
        if($updatecolumn){

            Flash::success('Qrcode saved successfully.');
        } else{

            Flash::error('Qrcode failed. Try again.');

        }
           // return redirect(route('qrcodes.show',['qrcode'=>$qrcode]));
           return redirect(route('qrcodes.show', $qrcode->id ));

        
    }

    /**
     * Display the specified Qrcode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $transactions = $qrcode->transactions;

        return view('qrcodes.show')->with('transactions', $transactions)->with('qrcode', $qrcode);
    }

    /**
     * Show the form for editing the specified Qrcode.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        return view('qrcodes.edit')->with('qrcode', $qrcode);
    }

    /**
     * Update the specified Qrcode in storage.
     *
     * @param  int              $id
     * @param UpdateQrcodeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateQrcodeRequest $request)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $qrcode = $this->qrcodeRepository->update($request->all(), $id);

        Flash::success('Qrcode updated successfully.');

        return redirect(route('qrcodes.show',$qrcode->id));
    }

    /**
     * Remove the specified Qrcode from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $qrcode = $this->qrcodeRepository->findWithoutFail($id);

        if (empty($qrcode)) {
            Flash::error('Qrcode not found');

            return redirect(route('qrcodes.index'));
        }

        $this->qrcodeRepository->delete($id);

        Flash::success('Qrcode deleted successfully.');

        return redirect(route('qrcodes.index'));
    }
}
