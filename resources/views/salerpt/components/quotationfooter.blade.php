{{-- Footer  --}}
<div style="margin-top:10px;">

    <table>
        <tbody>
                <tr>
                <td  style="text-align: left;">
                    <span style="font-size:1.5rem;font-weight: bold">SUMMARY</span>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="data1" >

        <tbody>
            {{ $vvlues = 0 }}
            @for ($i = 0 ; $i < count($nogrp) ; $i++)
                    <tr>
                        {{ $vvlues += $nogrp[$i]->saleamnt }}
                        <td style="font-size:12px" width="4%">{{ $i+1 }}</td>
                        {{-- <td class="" width="16%">{{ $data[$i]->grpname }} </td> --}}
                        <td style="font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="40%">{{ $nogrp[$i]->matname }} </td>
                        <td style="text-align:center;font-size:12px ;font-weight: bold;" width="7%">{{ $nogrp[$i]->UOM }} </td>
                        <td style="text-align:left;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="20%">{{ $nogrp[$i]->mybrand }} </td>
                        <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($nogrp[$i]->qty,1) }} </td>
                        <td style="text-align:right;font-size:12px;border-right: 1.5px solid burlywood;font-weight: bold;" width="9%">{{ number_format($nogrp[$i]->price,1) }} </td>
                        <td style="text-align:right;font-size:12px;font-weight: bold" width="11%">{{ number_format($nogrp[$i]->saleamnt,0) }} </td>

                    </tr>
            @endfor

            {{-- border:1px solid burlywood; --}}


            {{-- <h3 style="font-size:1rem">Term and condition: {{ $hdng3 }}</h3> --}}
        </tbody>
    </table>
</div>

<table style="border:1px solid gray">
    <tbody  >

        <tr style="width:100%;"  >
            <td  style="width:60%;font-size:14px;font-weight: bold;" > Term of Condition:  </td>
        </tr>
        <tr align ="left" style="width:60%;"  >
            <td align ="left" style="width:100%;font-size:12px;">
                {{ $t1 }}
            </td>
        </tr>
        <tr align ="left" style="width:60%;"  >
            <td align ="left" style="width:100%;font-size:12px;">
                {{ $t2 }}
            </td>
            </tr>
        <tr align ="left" style="width:60%;"  >
            <td align ="left" style="width:100%;font-size:12px;">
                {{ $t3 }}
            </td>
        </tr>
        <tr align ="left" style="width:60%;"  >
            <td align ="left" style="width:100%;font-size:12px;">
                {{ $t4 }}
            </td>
        </tr>
        <tr align ="left" style="width:60%;"  >
            <td align ="left" style="width:100%;font-size:12px;">
                {{ $t5 }}
            </td>
        </tr>

    </tbody>
</table>

<div style="margin-top:60px;">
    <table>
        <tbody>

            <tr style="margin-top:12px;margin-bottom:8px;" >
                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>
            </tr>

            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Prepared By
                </td>
                <td style="width=33%;font-size:80%;text-align:center">
                    Approved By
                </td>
            </tr>
        </tbody>
    </table>
</div>
