<!DOCTYPE html>
<html lang="en">
  <head>
	<title>Invoice</title>
  <!-- links and navbar -->
  <?php include "header.php" ?>
<script>
function pdf(){
            Popup($('.invoice')[0].outerHTML);
            function Popup(data) 
            {
                window.print();
                return true;
            }
        };
</script>
</head>
<body>    
<style>
body{
	background-color:black;
}
  #inventory-invoice{
    padding: 30px;
}
#inventory-invoice a{text-decoration:none ! important;}
.invoice {
    position: relative;
    background-color: #FFF;
    min-height: 680px;
    padding: 15px
}

.invoice header {
    padding: 10px 0;
    margin-bottom: 20px;
    border-bottom: 1px solid #3989c6
}

.invoice .company-details {
    text-align: right
}

.invoice .company-details .name {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .contacts {
    margin-bottom: 20px
}

.invoice .invoice-to {
    text-align: left
}

.invoice .invoice-to .to {
    margin-top: 0;
    margin-bottom: 0
}

.invoice .invoice-details {
    text-align: right
}

.invoice .invoice-details .invoice-id {
    margin-top: 0;
    color: #3989c6
}

.invoice main {
    padding-bottom: 50px
}

.invoice main .thanks {
    margin-top: -100px;
    font-size: 2em;
    margin-bottom: 50px
}

.invoice main .notices {
    padding-left: 6px;
    border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
    font-size: 1.2em
}

.invoice table {
    width: 100%;
    border-collapse: collapse;
    border-spacing: 0;
    margin-bottom: 20px
}

.invoice table td,.invoice table th {
    padding: 15px;
    background: #eee;
    border-bottom: 1px solid #fff
}

.invoice table th{
	color:#3989c6;
    white-space: nowrap;
    font-weight: 400;
    font-size: 16px;
    border:1px solid #fff;
}
.invoice table td{
    border:1px solid #fff;
}
.invoice table td h3 {
    margin: 0;
    font-weight: 400;
    color: #3989c6;
    font-size: 1.2em
}

.invoice table .tax,.invoice table .total,.invoice table .unit {
    text-align: right;
    font-size: 1.2em
}

.invoice table .no {
    color: #fff;
    font-size: 1.6em;
    background: #17a2b8
}

.invoice table .unit {
    background: #ddd
}

.invoice table .total {
    background: #17a2b8;
    color: #fff
}

.invoice table tfoot td {
    background: 0 0;
    border-bottom: none;
    white-space: nowrap;
    text-align: right;
    padding: 10px 20px;
    font-size: 1.2em;
    border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
    border-top: none
}

.invoice table tfoot tr:last-child td {
    color: #3989c6;
    font-size: 1.4em;
    border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
    border: none
}

.invoice footer {
    width: 100%;
    text-align: center;
    color: #777;
    border-top: 1px solid #aaa;
    padding: 8px 0
}

@media print {
    .invoice {
        font-size: 11px!important;
        overflow: hidden!important
    }

    .invoice footer {
        position: absolute;
        bottom: 10px;
        page-break-after: always
    }

    .invoice>div:last-child {
        page-break-before: always
    }
}
  </style>
  <?php 
  $msg="";
  ?>
  <section class="ftco-section ftco-cart">
    	<div class="container">
<div id="inventory-invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button class="btn btn-info" onclick='pdf()'><i class="fa fa-file-pdf-o"></i> Export as PDF</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col">
                        <a target="_blank" href="#">
                            <h1>RENT&RIDE</h1>
                            </a>
                    </div>
                </div>
            </header>
            <main>
			<?php
               

                // echo '<h1 class="mb-3 bread"><center>You\'ve paid due</center></h1>';
                $cname=$_GET['bid'];
				$rows = $mng->executeQuery("riderent.booking",$query);
				foreach ($rows as $row)
				{
                    if($row->car_name == $cname){
						
			?>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">INVOICE TO:</div>
                        <h2 class="to"><?php echo $row->f_name; ?></h2>
                        <div class="email"><?php echo $_SESSION['email']; ?></div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE</h1>
                        <div class="date">Date of Invoice:</div>
                        <div id="date"></div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th>Car</th>
                            <th class="text-left">Pick-up Location</th>
                            <th class="text-right">Drop-off Location</th>
                            <th class="text-right">Fare</th>
                            <th class="text-right">Distance</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $row->car_name; ?></td>
							<td data-column="PickUp Location"><?php echo $row->pickup_loc; ?></td>
							<td data-column="DropOff Location"><?php echo $row->dropoff_loc; ?></td>
                            <td class="Fare"><?php echo $row->Fare; ?></td>
                            <td class="Distance"><?php echo $row->Distance; ?></td>
                            <td class="Total"><?php echo $row->Total; ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">SUBTOTAL</td>
                            <td><?php echo $row->Total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">TAX 18%</td>
                            <td><?php $sb=$row->Total*0.18; echo $sb; ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td colspan="2">GRAND TOTAL</td>
                            <td><?php $tt=$sb+$row->Total; echo $tt; ?></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="thanks">Thank you!</div>
                <div class="notices">
                    <div>NOTICE:</div>
                    <div class="notice">System Generated Invoice.</div>
                </div>
                <div class="toolbar hidden-print">
                    <div class="text-right">
                            <button class="btn btn-info" ><i class="fa fa-file-pdf-o"></i><a href="sendbill.php?bid=<?php echo $row->car_name;?>" style="color:white"> Send to Mail</a></button>
                    </div>
                    <hr>
                </div>
			<?php 
                    }
				}
			?>
            </main>
            <footer>
                Invoice was generated on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <div></div>
    </div>
</div>
</div>
</section>
<script>
n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();
document.getElementById("date").innerHTML = m + "/" + d + "/" + y;
</script>

<!-- footer -->
	<?php include "footer.html"?>     
</body>
</html>