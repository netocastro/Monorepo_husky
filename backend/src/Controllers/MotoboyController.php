<?php

namespace Source\Controllers;

use Source\Models\Motoboy;

class MotoboyController
{
    /**
     * 
     * @OA\Get(
     *     path="/development/entrevistas/Husky/motoboy",
     *     tags={"Motoboy"},
     *     summary="Retorna o registro de todos os motoboys.",
     *         *     @OA\Response(
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
        echo json_encode(objectToArray((new Motoboy())->find()->fetch(true)));
    }

    
    public function store(array $data): void
    {
        $motoboy = new Motoboy();
        $motoboy->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $motoboy->save();

        if ($motoboy->fail()) {
            echo json_encode($motoboy->fail()->getMessage());
            return;
        }

        echo json_encode(["success" => "salvo com sucesso"]);
    }

    public function show(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);
        echo json_encode(objectToArray((new Motoboy())->findById($id)));
    }

    public function update(array $data): void
    {
        $id = filter_var($data['id'], FILTER_SANITIZE_NUMBER_INT);

        $motoboy = (new Motoboy())->findById($id);
        $motoboy->name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $motoboy->change()->save();

        if ($motoboy->fail()) {
            echo json_encode($motoboy->fail()->getMessage());
            return;
        }

        echo json_encode(["success" => "atualizado com sucesso"]);
    }

    /**
     * @OA\Delete(
     *     path="/development/entrevistas/Husky/motoboy/{id} ",
     *     tags={"Motoboy"},
     *     summary="Deleta o registro de um motoboy.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="id do motoboy que precisa apagar",
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

        $motoboy = (new Motoboy())->findById($id);
        if ($motoboy) {
            $motoboy->destroy();
            echo json_encode(["success" => "deletado com sucesso"]);
        } else {
            echo json_encode("Motoboy inválido.");
        }
    }
}
