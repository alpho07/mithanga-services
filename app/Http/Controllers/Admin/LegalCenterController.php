<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalCenter;
use Illuminate\Http\Request;

/**
 * Class LegalCenterController
 * @package App\Http\Controllers
 */
class LegalCenterController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $legalCenters = LegalCenter::paginate();

        return view('legal-center.index', compact('legalCenters'))
                        ->with('i', (request()->input('page', 1) - 1) * $legalCenters->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $legalCenter = new LegalCenter();
        return view('legal-center.create', compact('legalCenter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(LegalCenter::$rules);

        $legalCenter = LegalCenter::create($request->all());

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $legalCenter = LegalCenter::find($id);

        return view('legal-center.show', compact('legalCenter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $legalCenter = LegalCenter::find($id);

        return view('legal-center.edit', compact('legalCenter'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  LegalCenter $legalCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LegalCenter $legalCenter, $id) {
        $legalCenter = LegalCenter::find($id);
        request()->validate(LegalCenter::$rules);

        $legalCenter->update($request->all());

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $legalCenter = LegalCenter::find($id)->delete();

        return redirect()->route('legal-centers.index')
                        ->with('success', 'LegalCenter deleted successfully');
    }

}
