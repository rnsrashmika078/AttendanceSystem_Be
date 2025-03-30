<?php

namespace App\Http\Controllers;

use App\Models\QrCode;
use Illuminate\Http\Request;

class QrCodeController extends Controller
{

    public function getQRCode($id)
    {
        $qrCode = QrCode::find($id);
        if ($qrCode) {
            return response()->json([
                'data' => $qrCode,
            ]);
        } else {
            return response()->json([
                'message' => 'QR Code not found.',
            ], 404);
        }
    }
    public function createQR_ID(Request $request)
    {
        $qr = QrCode::create([
            'id' => $request->id
        ]);
        if ($qr) {
            return response()->json([
                'success' => true,
                'message' => 'QR Code has been Updated!',
                'data' => $qr

            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'QR Code has been Updated!',

            ]);
        }
    }
    public function updateQRCode(Request $request, $id)
    {
        $request->validate([
            // 'id' => 'required|string',
            'qr_code' => 'nullable|string',
        ]);
        $upDateQRCode = QrCode::find($id);
        if ($upDateQRCode) {
            $upDateQRCode->update([
                // 'id' => $request->id ?? $upDateQRCode->id,
                'qr_code' => $request->qr_code ?? $upDateQRCode->qr_code,
            ]);
            return response()->json([
                'success' => $upDateQRCode,
                'message' => 'QR Code has been Updated!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'error while adding qr code to the database',
        ], 404);
    }
}
