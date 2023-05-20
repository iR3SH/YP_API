<?php

namespace App\Http\Controllers;

use App\Models\ReportedUsers;
use Facade\FlareClient\Report;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportedUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/reportedUsers",
     *      operationId="indexReportedUsers",
     *      tags={"ReportedUsers"},
     *      summary="Get list of ReportedUsers",
     *      description="Returns list of ReportedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="idUser",
     *         in="query",
     *         description="id of the User who ask the request",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns list of ReportedUsers
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'idUser' => 'required'
        ]);
        if($this->isAdminUser($request->get('idUser'))) {
            $reportedUsers = ReportedUsers::lastest()->paginate(10);

            return $this->sendResponse($reportedUsers, "List send successfully");
        }
        else{
            return $this->sendError('Route not found');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    /**
     * @OA\Post(
     *      path="/api/reportedUsers",
     *      operationId="storeReportedUsers",
     *      tags={"ReportedUsers"},
     *      summary="Report a Users",
     *      description="Returns a ReportedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="reason",
     *         in="query",
     *         description="reason of the report",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="content of the report",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="reportedUser",
     *         in="query",
     *         description="id of the User who's been reported",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="userWhoReported",
     *         in="query",
     *         description="id of the User who reported",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a ReportedUsers
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            "reason" => 'required',
            "content" => 'required',
            "reportedUser" => 'required',
            "userWhoReported" => 'required',
        ]);
        $verif = ReportedUsers::where('reportedUser',$request->get('reportedUser'))->where('userWhoReported', $request->get('userWhoReported'))->get();
        if(count($verif) > 0){
            return $this->sendError('User already reported');
        }
        $reportedUsers = ReportedUsers::create($request->all());

        return $this->sendResponse($reportedUsers, "User reported successfully");
    }
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @param ReportedUsers $reportedUser
     * @return JsonResponse
     */
    /**
     * @OA\Get(
     *      path="/api/reportedUsers/{id}",
     *      operationId="showReportedUsers",
     *      tags={"ReportedUsers"},
     *      summary="Get the reports from one Users",
     *      description="Returns a ReportedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Not used",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="reportedUser",
     *         in="query",
     *         description="id of the User who's been reported",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a ReportedUsers
     */
    public function show(Request $request, ReportedUsers $reportedUser): JsonResponse
    {
        $request->validate([
            'reportedUser' => 'required'
        ]);
        $reports = ReportedUsers::where('reportedUser', $request->get('reportedUser'));
        if(count($reports) > 0){
            return $this->sendResponse($reports, 'List generated');
        }
        else {
            return $this->sendError("User isn't reported yet");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ReportedUsers $reportedUsers
     * @return Response
     */
    public function edit(ReportedUsers $reportedUsers)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param ReportedUsers $reportedUsers
     * @return JsonResponse
     */
    /**
     * @OA\Patch(
     *      path="/api/reportedUsers/{id}",
     *      operationId="updateReportedUsers",
     *      tags={"ReportedUsers"},
     *      summary="Update a Report",
     *      description="Returns a ReportedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the report",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="reason",
     *         in="query",
     *         description="reason of the report",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="content",
     *         in="query",
     *         description="content of the report",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="reportedUser",
     *         in="query",
     *         description="id of the User who's been reported",
     *         required=true,
     *      ),
     *      @OA\Parameter(
     *         name="userWhoReported",
     *         in="query",
     *         description="id of the User who reported",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a ReportedUsers
     */
    public function update(Request $request, ReportedUsers $reportedUsers): JsonResponse
    {
        $request->validate([
            "reason" => 'required',
            "content" => 'required',
            "reportedUser" => 'required',
            "userWhoReported" => 'required',
        ]);

        $reportedUsers->update($request->all());
        return $this->sendResponse($reportedUsers, "Report updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ReportedUsers $reportedUsers
     * @return JsonResponse
     */
    /**
     * @OA\Delete(
     *      path="/api/reportedUsers/{id}",
     *      operationId="deleteReportedUsers",
     *      tags={"ReportedUsers"},
     *      summary="Delete a Report",
     *      description="Returns a ReportedUsers",
     *      security={{ "bearer_token": {} }},
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id of the report",
     *         required=true,
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *           @OA\JsonContent(
     *             @OA\Property(property="status", type="integer", example="200"),
     *             @OA\Property(property="data",type="object"),
     *             @OA\Property(property="message",type="string")
     *          )
     *       )
     * )
     *
     * Returns a ReportedUsers
     */
    public function destroy(ReportedUsers $reportedUsers): JsonResponse
    {
        $reportedUsers->delete();
        return $this->sendResponse($reportedUsers, "Report deleted successfully");
    }
}
