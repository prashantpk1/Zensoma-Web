<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Transaction::with('user_data')->where('is_delete',0)->orderBY('id','DESC')->get();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert_delete = "return confirm('Are you sure want to delete !')";
                    $btn = "<ul class='action'>";
                    $btn = $btn . ' <li class="delete"><a href="" data-url="' . route('transaction.destroy', $row->id) . '" class="destroy-data" title="Delete"> <i class="icon-trash"></i></a></li> </ul>';
                    return $btn;

                })

                ->addColumn('status', function ($data) {
                    if ($data->status == "success") {
                        return '<span class="badge bg-success">Success</span>';
                    }else if ($data->status == "failed") {
                        return '<span class="badge bg-danger">Failed</span>';
                    }
                    else {
                        return '<span class="badge bg-info">Pendding</span>';
                    }
                })



                ->addColumn('created_at', function ($data) {
                    return date('Y-M-d h:i A', strtotime($data->created_at));

                })

                ->addColumn('user_detail', function ($data) {
                    if ($data->user_data->profile_image == null && $data->user_data->profile_image == "") {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/admin/assets/images/user/user.png' . '  alt="Generic placeholder image"> <div class="media-body">
                          <div class="row">
                            <div class="col-xl-12">
                            <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->name . '</span></h6>
                            </div>
                          </div>
                          <p>&nbsp;&nbsp; ' . $data->user_data->email . '</p>
                        </div>
                      </div>
                    </li>
                  </ul>';
                    } else {
                        return ' <ul>
                        <li>
                          <div class="media"><img class="b-r-8 img-40" src=' . URL::to('/public') . '/profile_image/' . $data->user_data->profile_image . '  alt="Generic placeholder image">
                            <div class="media-body">
                              <div class="row">
                                <div class="col-xl-12">
                                <h6 class="mt-0">&nbsp;&nbsp; ' . $data->user_data->name . '</span></h6>
                                </div>
                              </div>
                              <p>&nbsp;&nbsp; ' . $data->user_data->email . '</p>
                            </div>
                          </div>
                        </li>
                      </ul>';
                    }
                })

                ->rawColumns(['action','status','user_detail'])
                ->make(true);
        }
        return view('Admin.Transactions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            DB::beginTransaction();
            $data = Transaction::find($id);
            $data->is_delete = 1;
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Data Deleted Successfully.']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function themeStatus($id)
    {
        try {
            DB::beginTransaction();
            $data = Theme::find($id);
            if ($data->status == 1) {
                $data->status = 0;
                $message = "Deactived";
            } else {
                $data->status = 1;
                $message = "Actived";
            }
            $data->update();
            DB::commit(); // Commit Transaction
            return response()->json(['status' => '1', 'success' => 'Data ' . $message . ' Successfully']);
        } catch (\Exception $e) {
            DB::rollBack(); //Rollback Transaction
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}
