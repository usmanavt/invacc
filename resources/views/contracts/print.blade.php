<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
* {
    margin:0;
    padding:0;
    font-size:0.8rem;
    box-sizing: border-box;
}
th{
    font-style: bold;
    /* font-size: 0.8rem; */
}
.right-border {
    border-right: 1px solid lightgray;
    padding-right:2px;
}
.a4{
    /* width: 21cm;
    height: 29.7cm;
    margin: 30mm 45mm 30mm 45mm;  */
     /* gray; */
    margin-top:5px;
    font-size: 0.5rem;
}
.border {
    border:1px solid lightgray;
}

</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}
        
    <div>
        {{-- Report Header --}}
        <table width="100%" style="margin-bottom:12px">
            <tbody>
                <tr>
                    {{-- logo --}}
                    <td align="left" style="width:20%;vertical-align:top;">
                        <svg  viewBox="0 0 128 48" xmlns="http://www.w3.org/2000/svg">
                            <path
                            d="m 37.980371,7.4635276 c -2.853661,-0.196078 -5.743096,1.304995 -7.439516,3.3664104 -6.230513,8.825148 -12.082605,19.057448 -17.22614,27.494088 -1.308216,2.03759 -3.8469055,7.1422 -3.8469055,7.1422 h 6.7886375 c 0,0 7.645406,-11.45525 11.455974,-17.63634 2.612102,-4.18791 5.175917,-8.43372 7.835243,-12.587342 1.901502,-1.731159 4.327546,-2.884979 6.138193,-0.594216 1.519918,2.474058 4.415154,6.918308 5.091171,8.033328 2.340582,3.79553 4.726239,7.49549 7.071908,11.28643 1.831537,2.73462 3.339738,5.73235 5.487319,8.21712 0.853326,2.21193 7.770523,5.27057 5.5444,4.45498 3.445856,0.7891 7.0058,-0.64379 9.249453,-3.25311 2.331008,-2.67564 3.965971,-5.90279 5.43109,-9.1928 2.411951,-5.07951 4.789349,-10.23633 7.212911,-15.331 0.431429,-3.01046 4.681776,-5.508449 4.950164,-5.105863 7.646687,0 15.293377,0 22.940067,0 0,0 2.36119,-3.402943 3.59218,-4.8792394 0.20799,-0.56753 1.67967,-1.695613 0.18324,-1.400769 -9.6239,0.04435 -19.267879,-0.153914 -28.879618,0.09943 -3.368398,0.321661 -6.082473,2.5926494 -7.227178,5.6572784 -1.412788,2.442976 -2.568148,5.068533 -3.917416,7.609053 -2.616484,5.22505 -5.230205,10.32655 -7.821396,15.52907 -0.944908,1.90197 -2.164796,4.6278 -4.836873,4.07311 -1.968234,-0.80459 -2.621968,-3.03052 -3.818786,-4.61068 -4.281101,-7.08819 -8.39136,-13.22666 -12.389264,-19.72933 -1.736856,-2.9304 -3.724713,-6.102376 -6.958194,-7.6090574 -1.425229,-0.697851 -3.015946,-1.064061 -4.610672,-1.032755 z m 61.027316,12.3684884 h -5.529702 l -1.810363,2.63749 h 5.479483 7.616895 c 0,0 0.54836,2.16745 0.56151,3.08159 -0.10126,6.78259 -0.0663,19.64635 -0.0663,19.64635 h 2.43965 c 0,0 0.22564,-14.91704 -0.16263,-21.97823 0.7965,-3.84064 -4.94193,-3.58946 -5.08641,-3.3872 z m -58.524124,7.40365 c -3.00528,-0.15603 -6.304432,0.30928 -8.415199,2.55985 -1.63321,1.53696 -2.675342,3.44592 -3.875026,5.16251 -1.98641,3.30221 -5.544387,9.61729 -5.544387,9.61729 h 4.412605 c 0,0 3.656106,-7.36098 5.855345,-10.551 1.312529,-1.96015 3.426579,-3.52622 5.961697,-3.41554 2.973857,-0.0943 6.372333,0.11693 9.001682,-0.007 -0.991861,-1.12474 -2.06445,-2.25248 -3.224568,-3.19604 -1.388519,-0.0465 -2.778202,-0.15415 -4.172149,-0.16997 z" />
                        </svg>
                    </td>
                    <td align="center" style="width:60%;vertical-align:top;">
                        <h1>Company Name </h1>
                    </td>
                    <td align="right" style="width:20%;vertical-align:top;">
                        &nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            </tbody>
        </table>

        <table width="100%">
            <tbody>
                <tr>
                    <td  style="text-align: center;">
                        <h3 style="font-size:0.7rem">Company Address</h3>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="100%">
            <tbody>
                <tr>
                    <td align="center">
                        <h3 style="margin:0;">Contract</h3>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- Relevant --}}
        <table width="100%" style="margin-bottom:8px;" class="border">
            <tr>
                <td width="15%" align="right" class="right-border">Contract #</td>
                <td width="30%" align="left">{{$contract->number}}</td>
                <td width="10%"></td>
                <td width="15%" align="right" class="right-border">Invoice Date</td>
                <td width="30%" align="left">@if ($contract->invoice_date != '') {{ $contract->invoice_date->format('d-m-Y')}} @endif</td>
            </tr>
            <tr>
                <td width="15%" align="right" class="right-border">Supplier</td>
                <td width="30%" align="left">{{$contract->supplier_id}} | {{$contract->supplier->title}}</td>
                <td width="10%"></td>
                <td width="15%" align="right" class="right-border"></td>
                <td width="30%" align="left"></td>
            </tr>
       
         
            {{-- <tr>
                <td width="10%" align="right" class="right-border">Remarks</td>
                <td colspan="4" width="90%">{{ $gp->remarks}}</td>
            </tr> --}}
        </table>
        {{-- column headers --}}
        <table width="100%" cellspacing="0">
            <thead class="details">
                <tr>
                    <th class="border" width="5%" style="text-align:center;">S#</th>
                    <th class="border" width="25%" style="text-align:center;">Material</th>
                    <th class="border" width="10%" style="text-align:center;">Sku</th>
                    <th class="border" width="10%" style="text-align:center;">BND1</th>
                    <th class="border" width="10%" style="text-align:center;">PCS/BND1</th>
                    <th class="border" width="10%" style="text-align:center;">BND2</th>
                    <th class="border" width="10%" style="text-align:center;">PCS/BND2</th>
                    <th class="border" width="10%" style="text-align:center;">WT(M)</th>
                    <th class="border" width="10%" style="text-align:center;">Rate</th>
                </tr>
            </thead>
            <tbody class="details">
                @foreach ($cd as $index => $item)
                <tr>
                    <td class="border" width="5%" align="center" >{{$index+1}}</td>
                    <td class="border" width="25%" align="left" style="padding-left:5px">{{ $item->material_title}}</td>
                    <td class="border" width="10%" align="left" >{{ $item->sku }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->bundle1) }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->pcspbundle1) }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->bundle2) }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->pcspbundle2) }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->gdswt) }}</td>
                    <td class="border" width="10%" align="center" >{{ number_format($item->gdsprice) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        {{-- Footer  --}}
        {{-- <div style="margin-top:64px;">
            <table width="100%">
                <tr>
                    <td style="width=33%;font-size:80%;text-align:center">
                        Prepared By
                    </td>
                    <td style="width=33%;font-size:80%;text-align:center">
                        HOD
                    </td>
                    <td style="width=33%;font-size:80%;text-align:center">
                        Approved By
                    </td>
                </tr>
                <tr style="margin-top:16px;margin-bottom:16px;">
                    <td style="width=33%;font-size:80%;text-align:center">
                        --------------------
                    </td>
                    <td style="width=33%;font-size:80%;text-align:center">
                        --------------------
                    </td>
                    <td style="width=33%;font-size:80%;text-align:center">
                        --------------------
                    </td>
                </tr>
            </table>
        </div> --}}

        <div class="footer">

        </div>
    </div>
        
    </body>
</html>  