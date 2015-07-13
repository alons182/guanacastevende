<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class ApiController extends Controller {

    protected $statusCode = 200;
    const HTTP_NOT_FOUND = 404;


    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($message = 'Not Found!')
    {

        $this->setStatusCode(Response::HTTP_NOT_FOUND);
        return $this->respondWithError($message);

    }

    /**
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondInternalError($message = 'Internal Error!')
    {

        $this->setStatusCode(500);
        return $this->respondWithError($message);

    }

    /**
     * @param $data
     * @param array $headers
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($message)
    {
        return $this->respond([
            'error' => [
                'message' => $message,
                'status_code' => $this->getStatusCode()
            ]
        ]);
    }

    /**
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($message)
    {
        $this->setStatusCode(201);

        return $this->respond([
            'message' => $message

        ]);
    }

    /**
     * @param $products
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithPagination(Paginator $products, $data)
    {
        $data = array_merge($data, [
            'paginator' => [
                'total_count'  => $products->total(),
                'total_pages'  => ceil($products->total() / $products->perPage()),
                'current_page' => $products->currentPage(),
                'limit'        => $products->perPage()
            ]
        ]);

        return $this->respond($data);

    }


}