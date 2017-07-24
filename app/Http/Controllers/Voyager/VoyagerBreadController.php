<?php

namespace App\Http\Controllers\Voyager;

use TCG\Voyager\Http\Controllers\VoyagerBreadController as BaseVoyagerBreadController;

class VoyagerBreadController extends BaseVoyagerBreadController
{
    // POST BR(E)AD
    public function update(Request $request, $id)
    {
    	dd($id);
        $slug = $this->getSlug($request);

        $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();

        // Check permission
        Voyager::canOrFail('edit_'.$dataType->name);

        $data = call_user_func([$dataType->model_name, 'findOrFail'], $id);

        $this->insertUpdateData($request, $slug, $dataType->editRows, $data);

        return redirect()
            ->route("voyager.{$dataType->slug}.edit", ['id' => $id])
            ->with([
                'message'    => "Успешно обновлен {$dataType->display_name_singular}",
                'alert-type' => 'success',
            ]);
    }
}
