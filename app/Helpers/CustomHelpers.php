<?php
function customHelper($request){
        $token = $request->_token;
        return response('Cookie has been set')
            ->cookie('token', $token, 60);
}