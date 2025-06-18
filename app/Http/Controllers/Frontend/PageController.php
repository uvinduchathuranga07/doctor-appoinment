<?php

namespace App\Http\Controllers\Frontend;


use App\Http\Controllers\Controller;
use App\Mail\ContactMailable;
use App\Models\Contact;
use App\Models\Customer;
use App\Models\Feature;
use App\Models\Inquiry;
use App\Models\Manufacture;
use App\Models\Settings;
use App\Models\Testimonial;
use App\Models\Type;
use App\Models\Vehicle;
use App\Models\VehicleModel;
use App\Services\ApiClient\ApiClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Mail;

class PageController extends Controller
{
    public function about()
    {
        // dd('test');
        $image_url = 'images/about.jpg';

        return Inertia::render('About/index', ['image_url' => $image_url]);
        // return Inertia::render('About/index');
    }

    public function auction(Request $request)
    {
        $id = $request->id;
        $requestData = $request->all();

        if (!$id) {
            return redirect()->back();
        }

        $query = "SELECT * FROM main WHERE id = '" . $id . "' order by marka_name ASC";
        $details = ApiClient::callAuctionApi($query, true);
        // dd($id);
        $details = count($details) > 0 ? $details[0] : null;

        $images = $details ? explode('#', $details['IMAGES']) : [];

        // stats filter queries
        $statsYearQuery = "SELECT count(year), year FROM stats ";
        $statsChassiesQuery = "SELECT count(kuzov), kuzov FROM stats ";
        $statsConditionQuery = "SELECT count(rate), rate FROM stats ";

        if ($request->manufacture) {
            $statsYearQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
            $statsChassiesQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
            $statsConditionQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
        }

        if ($request->model) {
            $statsYearQuery .= "AND model_name = '" . $request->model . "' ";
            $statsChassiesQuery .= "AND model_name = '" . $request->model . "' ";
            $statsConditionQuery .= "AND model_name = '" . $request->model . "' ";
        }

        if ($request->chassis_no) {
            $statsConditionQuery .= "AND kuzov = '" . $request->chassis_no . "' ";
        }

        if ($request->year) {
            $statsChassiesQuery .= "AND year = '" . $request->year . "' ";
            $statsConditionQuery .= "AND year = '" . $request->year . "' ";
            $statsConditionQuery .= "AND year = '" . $request->year . "' ";
        }

        $statsYearQuery .= "GROUP BY year ORDER BY year DESC";
        $statsChassiesQuery .= 'GROUP BY kuzov ORDER BY kuzov ASC';
        $statsConditionQuery .= 'GROUP BY rate ORDER BY rate ASC';

        $statsYears = ApiClient::callAuctionApi($statsYearQuery);
        $statsChassis = ApiClient::callAuctionApi($statsChassiesQuery, true);
        $statsConditions = ApiClient::callAuctionApi($statsConditionQuery, true);

        $vehicleStatsList = $this->getVehicleStatsList($request);

        return Inertia::render('Auction_view/index', ['details' => $details, 'vImages' => $images, 'statsYears' => $statsYears, 'statsChassis' => $statsChassis, 'statsConditions' => $statsConditions, 'requestQuery' => $requestData, 'vehicleStatsList' => $vehicleStatsList]);
    }
    public function Live_auction(Request $request)
    {
        $requestData = $request->all();
        // dd($requestData);

        $auctionDatesQuery = "SELECT auction_date FROM main GROUP BY DATE_FORMAT(auction_date,'%Y-%m-%d')";
        $auctionDates = ApiClient::callAuctionApi($auctionDatesQuery);

        $manufcturesQuery = "SELECT DISTINCT marka_name FROM main ORDER BY marka_name ASC";
        $manufactures = ApiClient::callAuctionApi($manufcturesQuery, true);

        $models = [];
        if ($request->manufacturer) {
            $modelQuery = "SELECT DISTINCT MODEL_NAME FROM main WHERE marka_name='" . $request->manufacturer . "' ORDER BY MODEL_NAME ASC";
            $models = ApiClient::callAuctionApi($modelQuery, true);
        }

        $years = [];
        $chassisNumbers = [];
        $engineCapacity = [];
        $colorQuery = [];
        $ConditionQuery = [];
        $PriceQuery = [];
        $Mileages = [];

        if ($request->manufacturer && $request->model) {
            // get years
            $yearsQuery = "SELECT DISTINCT year FROM main WHERE marka_name='" . $request->manufacturer . "' AND MODEL_NAME='" . $request->model . "' ORDER BY year DESC";
            $years = ApiClient::callAuctionApi($yearsQuery, true);

            // get chassis number
            $chassisNoQuery = "SELECT DISTINCT kuzov FROM main WHERE marka_name='" . $request->manufacturer . "' AND model_name='" . $request->model . "' ";

            // get engine capacity
            $engineCapacityQuery = "SELECT DISTINCT eng_v FROM main WHERE marka_name='" . $request->manufacturer . "' AND model_name='" . $request->model . "' ";

            // get colors
            $vColorQuery = "SELECT DISTINCT COLOR FROM main WHERE marka_name='" . $request->manufacturer . "' AND model_name='" . $request->model . "' ";

            // get condition
            $vConditionQuery = "SELECT DISTINCT rate FROM main WHERE marka_name='" . $request->manufacturer . "' AND model_name='" . $request->model . "' ";

            // get price
            $vPriceQuery = "SELECT DISTINCT AVG_PRICE FROM main WHERE marka_name='" . $request->manufacturer . "' AND model_name='" . $request->model . "' ";

            // get Mileage
            $vMileageQuery = "SELECT DISTINCT MILEAGE FROM main WHERE marka_name='" . $request->manufacturer . "' AND MODEL_NAME='" . $request->model . "' ORDER BY MILEAGE ASC";


            // dd($vMileageQuery);

            if ($request->year_from == $request->year_to) {
                if ($request->year_from != 0) {
                    $chassisNoQuery .= "AND year = '" . $request->year_from . "' ";
                }
                if ($request->mileage_from == $request->mileage_to) {
                    $vMileageQuery .= "AND MILEAGE = '" . $request->year_from . "' ";
                }

                $engineCapacityQuery .= "AND year = '" . $request->year_from . "' ";

                $vColorQuery .= "AND year = '" . $request->year_from . "' ";

                $vConditionQuery .= "AND year = '" . $request->year_from . "' ";

                $vPriceQuery .= "AND year = '" . $request->year_from . "' ";
            } else if ($request->year_from && $request->year_to) {
                if ($request->year_from != 0 && $request->year_to != 0) {

                    $chassisNoQuery .= "AND year BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";
                }
                if ($request->mileage_from != 0 && $request->mileage_to != 0) {
                    $vMileageQuery .= "AND MILEAGE BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";
                }

                $engineCapacityQuery .= "AND year BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";

                $vColorQuery .= "AND year BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";

                $vConditionQuery .= "AND year BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";

                $vPriceQuery .= "AND year BETWEEN '" . $request->year_from . "' AND '" . $request->year_to . "' ";
            }

            $chassisNoQuery .= "ORDER BY kuzov ASC";

            $chassisNumbers = ApiClient::callAuctionApi($chassisNoQuery, true);

            $Mileages = ApiClient::callAuctionApi($vMileageQuery, true);


            // dd($Mileages);

            if ($request->chassis) {
                $engineCapacityQuery .= "AND kuzov = '" . $request->chassis . "' ";

                $vColorQuery .= "AND kuzov = '" . $request->chassis . "' ";

                $vConditionQuery .= "AND kuzov = '" . $request->chassis . "' ";

                $vPriceQuery .= "AND kuzov = '" . $request->chassis . "' ";
            }

            if ($request->engine) {
                $vColorQuery .= "AND eng_v = '" . $request->engine . "' ";

                $vConditionQuery .= "AND eng_v = '" . $request->engine . "' ";

                $vPriceQuery .= "AND eng_v = '" . $request->engine . "' ";
            }
            if ($request->grade) {

                $vPriceQuery .= "AND RATE = '" . $request->grade . "' ";
            }

            $engineCapacityQuery .= "order by eng_v ASC";
            $engineCapacity = ApiClient::callAuctionApi($engineCapacityQuery, true);

            $vConditionQuery .= "order by RATE ASC";
            $ConditionQuery = ApiClient::callAuctionApi($vConditionQuery, true);

            $vPriceQuery .= "order by AVG_PRICE ASC";
            $PriceQuery = ApiClient::callAuctionApi($vPriceQuery, true);

            $vColorQuery .= " order by COLOR ASC";
            $colorQuery = ApiClient::callAuctionApi($vColorQuery, true);
        }

        // $vehiclesList = [];
        // if($request->search == 'true') {
        // dd( $ConditionQuery);
        $vehiclesList = $this->getVehicleList($request);
        $vehiclesListCount = $this->getVehicleListCount($request);
        $vehiclesListCount = count($vehiclesListCount) > 0 ? $vehiclesListCount[0]['TAG0'] : 0;
        // }


        return Inertia::render('Live_auction/index', ['requestQuery' => $requestData, 'auctionDates' => $auctionDates, 'manufactures' => $manufactures, 'models' => $models, 'years' => $years, 'chassisNumbers' => $chassisNumbers, 'engineCapacity' => $engineCapacity, 'colorQuery' => $colorQuery, 'vehiclesList' => $vehiclesList, 'vehiclesListCount' => $vehiclesListCount, 'Condition' => $ConditionQuery, 'PriceQuery' => $PriceQuery, 'Mileage' => $Mileages,]);
    }
    public function service()
    {
        // dd('test');
        return Inertia::render('Services/index');
    }
    public function available(Request $request)
    {
        $requestData = $request->all();
        $vehicleTypes = Type::where(['status' => 1])->with('media')->get();
        $manufacturers = Manufacture::where(['status' => 1])->with('media')->get();
        $models = VehicleModel::where(['status' => 1])->get();

        // top filteration
        $vehiclesFilter = Vehicle::where(['status' => 1]);

        // vehicle list
        $vehicles = Vehicle::where(['status' => 1]);
        if ($request->brand) {

            if (is_array($request->brand)) {
                $vehicles = $vehicles->whereIn('manufacture_id', $request->brand);
            } else {
                $vehicles = $vehicles->where('manufacture_id', $request->brand);
            }
        }
        if ($request->model) {
            if (is_array($request->model)) {
                $vehicles = $vehicles->whereIn('vehicle_model_id', $request->model);
            } else {
                $vehicles = $vehicles->where('vehicle_model_id', $request->model);
            }
        }
        if ($request->type) {
            if (is_array($request->type)) {
                $vehicles = $vehicles->whereIn('vehicle_type_id', $request->type);
            } else {
                $vehicles = $vehicles->where('vehicle_type_id', $request->type);
            }
        }
        if ($request->drive_type) {
            // dd($request->drive_type);
            if (is_array($request->drive_type)) {
                $vehicles = $vehicles->whereIn('drive_type', $request->drive_type);
            } else {
                $vehicles = $vehicles->where('drive_type', $request->drive_type);
            }
        }
// dd($request->all());
        if ($request->sortBy) {
            // dd($request->sortBy);
            if ($request->sortBy == 'priceLowHigh') {
                $vehicles->orderBy('initial_payment', 'asc');
            }elseif($request->sortBy == 'priceHighLow'){
                $vehicles->orderBy('initial_payment', 'desc');
            }elseif($request->sortBy == 'newest'){
                $vehicles->orderBy('year', 'desc');
            }
        }
        if ($request->keyword) {
            $vehicles = $vehicles->where(function ($query) use ($request) {
                $query->where('drive_type', 'LIKE', '%' . $request->keyword . '%')
                      ->orWhereHas('manufacture', function ($q) use ($request) {
                          $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                      })
                      ->orWhereHas('vehicleModel', function ($q) use ($request) {
                          $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                      })
                      ->orWhereHas('vehicleType', function ($q) use ($request) {
                          $q->where('title', 'LIKE', '%' . $request->keyword . '%');
                      });
            });
        }
        $vehicles = $vehicles->with('media', 'vehicleType', 'manufacture', 'vehicleModel')->get();
        // dd($vehicles);
        return Inertia::render('Available_stock/index', ['vehicleTypes' => $vehicleTypes, 'manufacturers' => $manufacturers, 'models' => $models, 'vehicles' => $vehicles, 'requestQuery' => $requestData]);
    }
    public function faq()
    {
        // dd('test');
        return Inertia::render('FAQ/index');
    }
    public function knowledge()
    {
        // dd('test');
        return Inertia::render('Knowledge/index');
    }
    public function testimonials()
    {
        // dd('test');

        $testimonials = Testimonial::where('status', 1)->with('media')->get();
        // dd($testimonials->all());

        return Inertia::render('Testimonials/index', ['testimonials' => $testimonials]);
    }
    public function contact()
    {
        // dd('test');
        return Inertia::render('Contact_us/index');
    }
    public function HowtoOrder()
    {
        // dd('test');
        $site_url = 'https://nikoba.com';

        return Inertia::render('How_to_order/index', ['site_url' => $site_url]);
    }
    public function login()
    {
        // dd('test');
        return Inertia::render('Login/index');
    }
    public function register()
    {
        // dd('test');
        return Inertia::render('Register/index');
    }
    public function signup()
    {
        // dd('test');
        return Inertia::render('Login/index');
    }
    public function product(Request $request)
    {
        if (!$request->id) {
            return redirect()->back();
        }
        $vehicle = Vehicle::with('manufacture', 'vehicleModel', 'vehicleType', 'exColor', 'inColor', 'media')->find($request->id);

        $randomVehicles = Vehicle::with('media', 'manufacture', 'vehicleModel')
            ->where('id', '!=', $vehicle->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
        $features = json_decode($vehicle->features, true);
        //    $features  = json_decode($features, true);
        $features = Feature::whereIn('id', $features ?? [])->get();
        return Inertia::render('Product_view/index', ['vehicle' => $vehicle, 'features' => $features, 'randomVehicles' => $randomVehicles]);
    }
    public function forgotpassword()
    {
        // dd('test');
        return Inertia::render('Forgot_password/index');
    }
    public function profile()
    {

        $inquires = Inquiry::where('email', auth('customer')->user()?->email)->get();
        $affilates = DB::table('affiliates')->where('affiliate_id', auth('customer')->user()?->enrolled_affiliate_id)->get();
        $affilatesUserIDs = $affilates->pluck('customer_id');
        $affilateUsers = Customer::with('media')->whereIn('id', $affilatesUserIDs)->get();

        $affilateUsersCount = count($affilateUsers);
        $settingsAffiliate = Settings::where(['key' => 'affilate_point_value'])->first()->value ?? 0;
        $affiliatePoints = (int) $affilateUsersCount * (float) $settingsAffiliate;


        return Inertia::render('User_profile/index', ['inquires' => $inquires, 'affilateUsers' => $affilateUsers, 'affiliatePoints' => $affiliatePoints]);
    }
    public function PrivacyPolicy()
    {
        // dd('test');
        return Inertia::render('PrivacyPolicy/index');
    }
    public function NewPassword(Request $request)
    {
        // dd('test');
        return Inertia::render('NewPassword/index', ['token' => $request->token]);
    }

    public function getVehicleList(Request $request)
    {
        // dd($request);

        $vehiclesList = [];
        $query = "SELECT * FROM main WHERE 1=1 ";



        if ($request->search == 'true') {
            if ($request->manufacturer) {
                $query .= "AND marka_name = '" . $request->manufacturer . "' ";
            }

            if ($request->model) {
                $query .= "AND model_name = '" . $request->model . "' ";
            }

            if ($request->year_to == 0 && $request->year_from != 0) {
                $query .= "AND year >= '" . $request->year_from . "' ";
            } else if ($request->year_from == 0 && $request->year_to != 0) {
                $query .= "AND year <= '" . $request->year_to . "' ";
            } else if ($request->year_from != 0 && $request->year_to != 0) {
                $query .= "AND year >= '" . $request->year_from . "' AND year <= '" . $request->year_to . "' ";
            }

            if ($request->mileage_to == 0 && $request->mileage_from != 0) {
                $query .= "AND MILEAGE >= '" . $request->year_from . "' ";
            } else if ($request->mileage_from == 0 && $request->mileage_to != 0) {
                $query .= "AND MILEAGE <= '" . $request->mileage_to . "' ";
            } else if ($request->mileage_from != 0 && $request->mileage_to != 0) {
                $query .= "AND MILEAGE >= '" . $request->mileage_from . "' AND MILEAGE <= '" . $request->mileage_to . "' ";
            }

            if ($request->chassis) {
                $query .= "AND kuzov = '" . $request->chassis . "' ";
            }


            if ($request->engine) {
                $query .= "AND eng_v = '" . $request->engine . "' ";
            }


            if ($request->color) {
                $query .= "AND COLOR = '" . $request->color . "' ";
            }
            if ($request->grade) {
                $query .= "AND rate = '" . $request->grade . "' ";
            }

            if ($request->start_price) {
                $query .= "AND AVG_PRICE >= '" . $request->start_price . "' ";
            }

            if ($request->lot_no) {
                $query .= "AND LOT = '" . $request->lot_no . "' ";
            }
            // dd(explode(' ', $request->available_days)[0]);
            // if ($request->available_days) {
            //     $query .= "AND AUCTION_DATE LIKE '%" . explode(' ', $request->available_days)[0] . "%' ";
            //     // TODO: filter auctio for multiple available dates
            // }
            $page = $request->page ?? 1;
            $pageOffset = ($page - 1) * 10;

            $query .= ' ORDER BY year DESC LIMIT ' . $pageOffset . ',10';

            $vehiclesList = ApiClient::callAuctionApi($query);
        }


        return $vehiclesList;
    }

    public function getVehicleListCount(Request $request)
    {

        $vehiclesList = [];
        $query = "SELECT COUNT(*) FROM main WHERE 1=1 ";

        if ($request->search == 'true') {
            if ($request->manufacturer) {
                $query .= "AND marka_name = '" . $request->manufacturer . "' ";
            }

            if ($request->model) {
                $query .= "AND model_name = '" . $request->model . "' ";
            }

            if ($request->year_to == 0 && $request->year_from != 0) {
                $query .= "AND year >= '" . $request->year_from . "' ";
            } else if ($request->year_from == 0 && $request->year_to != 0) {
                $query .= "AND year <= '" . $request->year_to . "' ";
            } else if ($request->year_from != 0 && $request->year_to != 0) {
                $query .= "AND year >= '" . $request->year_from . "' AND year <= '" . $request->year_to . "' ";
            }

            if ($request->chassis) {
                $query .= "AND kuzov = '" . $request->chassis . "' ";
            }

            if ($request->engine) {
                $query .= "AND eng_v = '" . $request->engine . "' ";
            }

            // if ($request->color) {
            //     $query .= "AND COLOR = '" . $request->color . "' ";
            // }

            if ($request->lot_no) {
                $query .= "AND LOT = '" . $request->lot_no . "' ";
            }
            // dd(explode(' ', $request->available_days)[0]);
            // if ($request->available_days) {
            //     $query .= "AND AUCTION_DATE LIKE '%" . explode(' ', $request->available_days)[0] . "%' ";
            //     // TODO: filter auctio for multiple available dates
            // }

            $query .= ' ORDER BY year DESC';

            $vehiclesList = ApiClient::callAuctionApi($query);
        }


        return $vehiclesList;
    }

    public function getVehicleStatsList(Request $request)
    {

        $query = "SELECT * FROM stats WHERE 1=1 ";
        if ($request->manufacture) {
            $query .= "AND marka_name = '" . $request->manufacture . "' ";
        }

        if ($request->model) {
            $query .= "AND model_name = '" . $request->model . "' ";
        }

        if ($request->chassis_no) {
            $query .= "AND kuzov = '" . $request->chassis_no . "' ";
        }

        if ($request->engine) {
            $query .= "AND eng_v = '" . $request->engine . "' ";
        }

        if ($request->year) {
            $query .= "AND year = '" . $request->year . "' ";
        }

        if ($request->rate) {
            $query .= "AND rate = '" . $request->rate . "' ";
        }

        $page = $request->page > 0 ? $request->page : 1;
        $pageOffset = ($page - 1) * 10;

        $query .= "ORDER BY auction_date DESC LIMIT " . $pageOffset . ",10";

        // dd($query);
        $vehiclesStatList = ApiClient::callAuctionApi($query);

        return $vehiclesStatList;
    }
    public function AppDownload()
    {
        // dd('test');
        return Inertia::render('Download/AppDownload');
    }

    public function auctionStat(Request $request)
    {
        $id = $request->id;
        $requestData = $request->all();

        if (!$id) {
            return redirect()->back();
        }

        $query = "SELECT * FROM stats WHERE id = '" . $id . "' order by marka_name ASC";
        $details = ApiClient::callAuctionApi($query, true);

        // dd($id);

        $details = count($details) > 0 ? $details[0] : null;

        $images = $details ? explode('#', $details['IMAGES']) : [];

        // stats filter queries
        $statsYearQuery = "SELECT count(year), year FROM stats ";
        $statsChassiesQuery = "SELECT count(kuzov), kuzov FROM stats ";
        $statsConditionQuery = "SELECT count(rate), rate FROM stats ";

        if ($request->manufacture) {
            $statsYearQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
            $statsChassiesQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
            $statsConditionQuery .= "WHERE marka_name = '" . $request->manufacture . "' ";
        }

        if ($request->model) {
            $statsYearQuery .= "AND model_name = '" . $request->model . "' ";
            $statsChassiesQuery .= "AND model_name = '" . $request->model . "' ";
            $statsConditionQuery .= "AND model_name = '" . $request->model . "' ";
        }

        if ($request->chassis_no) {
            $statsConditionQuery .= "AND kuzov = '" . $request->chassis_no . "' ";
        }

        if ($request->year) {
            $statsChassiesQuery .= "AND year = '" . $request->year . "' ";
            $statsConditionQuery .= "AND year = '" . $request->year . "' ";
            $statsConditionQuery .= "AND year = '" . $request->year . "' ";
        }

        $statsYearQuery .= "GROUP BY year ORDER BY year DESC";
        $statsChassiesQuery .= 'GROUP BY kuzov ORDER BY kuzov ASC';
        $statsConditionQuery .= 'GROUP BY rate ORDER BY rate ASC';

        $statsYears = ApiClient::callAuctionApi($statsYearQuery);
        $statsChassis = ApiClient::callAuctionApi($statsChassiesQuery, true);
        $statsConditions = ApiClient::callAuctionApi($statsConditionQuery, true);

        $vehicleStatsList = $this->getVehicleStatsList($request);

        return Inertia::render('Auction_view/index', ['details' => $details, 'vImages' => $images, 'statsYears' => $statsYears, 'statsChassis' => $statsChassis, 'statsConditions' => $statsConditions, 'requestQuery' => $requestData, 'vehicleStatsList' => $vehicleStatsList]);
    }
    public function careers()
    {
        // dd('test');
        // $image_url = 'images/about.jpg';
        //our_deleveries
        // return Inertia::render('About/index', ['image_url' => $image_url]);
        return Inertia::render('Careers/index');
    }
    public function our_deleveries()
    {
        // dd('test');
        // $image_url = 'images/about.jpg';
        //our_deleveries
        // return Inertia::render('About/index', ['image_url' => $image_url]);
        return Inertia::render('Our_deliveries/index');
    }
    public function find_a_car()
    {
        // dd('test');
        // $image_url = 'images/about.jpg';
        //our_deleveries
        // return Inertia::render('About/index', ['image_url' => $image_url]);
        return Inertia::render('Find_a_car/index');
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'enquiry' => 'required'
        ]);

        $contact = Contact::create($validatedData);

        Mail::to('osura@eweblook.com')->send(new ContactMailable($validatedData));

        return Inertia::render('Contact_us/index', ['contact' => $contact,]);
    }
}
