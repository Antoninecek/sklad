
<?php
if ($this->pridej) {
    print_r($_SESSION['errmsg']);
    ?>

    <form id="" role="form" method="post" action="spravaimei/pridej">

        <div class="form-group">
            <div><input id="inventuraSkok" type="checkbox" title="skok"  tabindex="-1" checked> skok</div>
            <input id="inventuraPridejFormEan" class="form-control" pattern="[0-9]{11,13}" name="ean" title="EAN" value="" oninput="" onblur="" placeholder="EAN" autofocus required>

            <input id="inventuraPridejFormImei" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei" value="" placeholder="IMEI 1">
            <input id="inventuraPridejFormImei1" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei1" value="" placeholder="IMEI 2">
            <input id="inventuraPridejFormPotvrd" type="submit" class="btn btn-default" value="Pridej">
            <p id="inventuraText"></p>
        </div>
    </form>

    <?php
} else if ($this->smaz) {
    echo $this->inventuraEan;
    print_r($this->listImei);
    ?>
    <table class="table">
        <?php
        foreach ($this->listImei as $b) {
            ?>

            <tr>
                <td><?= $b['imei'] ?></td>
                <td><?= $b['imei1'] ?></td>
                <td><a href="spravaimei/smaz/<?= $this->inventuraEan ?>/<?= $b['imei'] ?>/<?= $b['imei1'] ?>" class="btn btn-default">smaz</a></td>
            </tr>
            <?php
        }
        ?>

    </table>



    <?php
} else if ($this->zobraz) {
    ?>
    <h3><?= $this->inventuraEan ?></h3>
    <table class="table">
        <?php
        foreach ($this->listImei as $b) {
            ?>
            <tr>
                <td><?= $b['imei'] ?></td>
                <td><?= $b['imei1'] ?></td>
                <td><?= $b['sum(kusy)'] ?>x</td>
                <td><a href="<?php
                    echo(
                    !empty($b['imei']) && $b['sum(kusy)'] < 0 ? 'spravaimei/pridej/' + $this->inventuraEan + '/' + $b['imei'] + '/' + $b['imei1'] : 'spravaimei/smaz/' + $this->inventuraEan + '/' + $b['imei'] + '/' + $b['imei1']
                    )
                    ?>" class="btn btn-default"><?php echo(
               !empty($b['imei']) && $b['sum(kusy)'] < 0 ? "srovnej" : "smaz")
                    ?></a></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
}
?>
    
<script type="text/javascript">

    $(document).ready(function () {
        console.log(window.location.href);
        console.log("<?= $this->akce ?>");
        /**if (window.location.href != "http://<?= SERVERURL ?><?= PATHBASE ?>spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>") {
         window.location.replace("spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>");
         //console.log("http://<?= SERVERURL ?><?= PATHBASE ?>spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>");
         }**/

        $('#inventuraPridejFormEan').on('input', function () {
            if (document.getElementById('inventuraSkok').checked) {
                setTimeout(function () {
                    $('#inventuraPridejFormImei').focus();
                }, 1500);
            }
        });

        $('#inventuraPridejFormImei').on('input', function () {
            if (document.getElementById("inventuraSkok").checked) {
                setTimeout(function () {
                    $("#inventuraPridejFormImei1").focus();
                }, 1500);
            }
        });

        $('#inventuraPridejFormPotvrd').on('click', function (e) {
            $('#inventuraPridejFormEan').val(myTrim($('#inventuraPridejFormEan').val()));
            $('#inventuraPridejFormImei').val(myTrim($('#inventuraPridejFormImei').val()));
            $('#inventuraPridejFormImei1').val(myTrim($('#inventuraPridejFormImei1').val()));
            if (!validateIMEI($('#inventuraPridejFormImei').val()) || !validateIMEI($('#inventuraPridejFormImei1').val())) {
                e.preventDefault();
                if (!validateIMEI($('#inventuraPridejFormImei').val())) {
                    $('#inventuraText').html("spatny imei 1");
                } else if (!validateIMEI($('#inventuraPridejFormImei1').val())) {
                    $('#inventuraText').html("spatny imei 2");
                }
            }
        });



    });

    function urlKontrola() {

        //window.location.replace("spravaimei/<?= $this->inventuraEan ?>");
    }

    function validateIMEI(value) {
        if (/[^0-9-\s]+/.test(value))
            return false;
        // The Luhn Algorithm. It's so pretty.
        var nCheck = 0, nDigit = 0, bEven = false;
        value = value.replace(/\D/g, "");
        for (var n = value.length - 1; n >= 0; n--) {
            var cDigit = value.charAt(n),
                    nDigit = parseInt(cDigit, 10);
            if (bEven) {
                if ((nDigit *= 2) > 9)
                    nDigit -= 9;
            }

            nCheck += nDigit;
            bEven = !bEven;
        }

        return (nCheck % 10) == 0;
    }

    function myTrim(x) {
        return x.replace(/^\s+|\s+$/gm, '');
    }

</script>