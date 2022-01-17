<?php

namespace Source\Controllers;

use Source\Models\Status;
use Stonks\Router\Router;

class StatusController
{
    /**
     * 
     * @OA\Get(
     *     path="/monorepo_husky/backend/status",
     *     tags={"Status"},
     *     summary="Retorna o registro de todos os status.",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *     ),
     * )
     */
    public function index(): void
    {
        echo json_encode(objectToArray((new Status())->find()->fetch(true)));
    }

    
    public function store(array $data): void
    {
        $status = new Status();
        $status->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $status->save();

        if ($status->fail()) {
            echo json_encode($status->fail()->getMessage());
            return;
        }

        echo json_encode(["success" => "salvo com sucesso"]);
    }

    /**
     * @OA\Get(
     *     path="/monorepo_husky/backend/status/{id}",
     *     tags={"Status"},
     *     summary="Essa rota devolve apenas um status especifico atraves do id.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do status",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="string"
     *         ),
     *     ),
     * )
     */
    public function show(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        echo json_encode(objectToArray((new Status())->findById($id)));
    }

    public function update(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $status = (new Status())->findById($id);
        $status->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $status->change()->save();

        if ($status->fail()) {
            echo json_encode($status->fail()->getMessage());
            return;
        }
        echo json_encode(["success" => "Atualizado com sucesso"]);
    }

    /**
     * @OA\Delete(
     *     path="/monorepo_husky/backend/status/{id} ",
     *     tags={"Status"},
     *     summary="Deleta um registro de um status.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do status que precisa apagar",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid username supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     )
     * )
     */
    public function delete(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $status = (new Status())->findById($id);
        if ($status) {
            $status->destroy();
            echo json_encode(["success" => "deletado com sucesso"]);
        } else {
            echo json_encode("Status inválido.");
        }
    }
}
