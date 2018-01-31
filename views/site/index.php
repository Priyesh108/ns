<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<section class="content-header">
    <h1>Dashboard<small></small></h1>
    <ol class="breadcrumb">
        <li class="active"><?= date('d-M-Y'); ?></li>
    </ol>
</section>
<section class="content">
    <?php if($module_check['Sharemarket-Ticker']) { ?>
    <div class="row">
        <div class="col-md-12">
                <iframe frameborder="0" src="http://www.indianotes.com/widgets/indices-ticker/index.php?type=indices-ticker&w=1170" width="1170" height="100" scrolling="no"></iframe>
        </div>
    </div>
    <?php } ?>
    <?php if($module_check['Bankdetails']) { ?>
        <div class="row" style="margin-top: 27px;">
            <div class="col-xs-12">
                <div class="box box-success">
                    <div class="box-header">
                        <h3 class="box-title"> Bank and Demat Details</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body table-responsive">
                        <table class="table table-hover table-bordered">
                            <tbody>
                            <tr>
                                <th>Name</th>
                                <th>Bank Account Number</th>
                                <!--<th>Bank Balance</th>-->
                                <th>Demat Account Number</th>
                                <th>Pan Card</th>
                                <th>Aadhar Card</th>
                                <th>Birth Date</th>
                            </tr>
                            <?php foreach ($bank_demat as $person) { ?>
                                <tr>
                                    <td><?= $person['name']; ?></td>
                                    <td><?= $person['bank_account_number']; ?></td>
                                    <!--<td><?/*= $person['bank_balance']; */?></td>-->
                                    <td><?= $person['demat_account_number']; ?></td>
                                    <td><?= $person['pan_card']; ?></td>
                                    <td><?= $person['aadhar_card']; ?></td>
                                    <td><?= date('d-M-Y', strtotime($person['birth_date'])); ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row" style="margin-top: 27px;">
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Enable-Disable Modules</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body">
                    <?php foreach ($module_check as $x=>$item) { ?>
                        <div class="form-check">
                            <label class="toggle-custom-label">
                                <input type="checkbox" name="check" id="<?=$x?>-module"><span class="label-text"><?= $x; ?></span>
                            </label>
                        </div>
                    <?php } ?>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-warning btn-flat pull-right" onclick="moduleUpdate()">Update</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-danger">
                <div class="box-header">
                    <h3 class="box-title">Pending Bills</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-hover table-bordered">
                        <tbody>
                        <tr>
                            <th>Bill No.</th>
                            <th>Name</th>
                            <th>Net Total</th>
                            <th>Billing Date</th>
                            <th>Due Date</th>
                            <th>Contact Number</th>
                            <th>Desciption</th>
                        </tr>
                        <?php foreach ($unPaidBills as $bill) { ?>
                            <tr>
                                <td><?= $bill['bill_no']; ?></td>
                                <td><?= $bill['company_name']; ?></td>
                                <td><?= $bill['net_total']; ?></td>
                                <td><?= date('d-M-Y', strtotime($bill['billing_date'])); ?></td>
                                <td><?= date('d-M-Y', strtotime("+3 months",strtotime(($bill['billing_date'])))); ?></td>
                                <td><?= $bill['mobile_number']; ?></td>
                                <td><?= $bill['description']; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo Yii::getAlias('@web') ?>/js/jquery.min.js"></script>

<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>
<?php if($module_check['Sharemarket-Graph']) { ?>
    <script type="text/javascript">
        new TradingView.widget({
            "width": 980,
            "height": 610,
            "symbol": "BSE:SENSEX",
            "interval": "D",
            "timezone": "Asia/Kolkata",
            "theme": "Light",
            "style": "2",
            "locale": "en",
            "toolbar_bg": "#f1f3f6",
            "enable_publishing": false,
            "allow_symbol_change": true,
            "watchlist": [
                "NSE:INFY",
                "NSE:RELIANCE",
                "BSE:JKIL",
                "NSE:PRESTIGE",
                "BSE:ESSELPRO",
                "BSE:COALINDIA",
                "BSE:ERIS",
                "BSE:IEX"
            ],
            "details": true,
            "hideideas": true,
            "show_popup_button": true,
            "popup_width": "1000",
            "popup_height": "650"
        });
    </script>
<?php } ?>
<script>
    var module_check = JSON.parse('<?= json_encode($module_check); ?>');
    $.each(module_check, function (key, value) {
       var id = '#'+key+'-module';
       console.log(id+' '+value);
       if(value == 0)
            $(id).prop('checked', false);
       else
           $(id).prop('checked', true);
    });
    //console.log(module_check);
    function moduleUpdate() {
        var customer_module = $('#Customers-module').is(":checked");
        var product_module = $('#Products-module').is(":checked");
        var price_module = $('#Price-module').is(":checked");
        var challan_module = $('#Challans-module').is(":checked");
        var bill_module = $('#Bills-module').is(":checked");
        var bankdetails_module = $('#Bankdetails-module').is(":checked");
        var sharemarket_ticker_module = $('#Sharemarket-Ticker-module').is(":checked");
        var sharemarket_graph_module = $('#Sharemarket-Graph-module').is(":checked");

        var url = '<?= Yii::$app->urlManager->createUrl('site/update-module'); ?>';
        $.ajax({
            url: url,
            data: {
                customer_module: customer_module,
                product_module : product_module,
                price_module : price_module,
                challan_module : challan_module,
                bill_module : bill_module,
                bankdetails_module : bankdetails_module,
                sharemarket_ticker_module : sharemarket_ticker_module,
                sharemarket_graph_module : sharemarket_graph_module
            },
            type: "POST",
            success: function (data) {
                window.location.reload();
            }
        })
    }
</script>
