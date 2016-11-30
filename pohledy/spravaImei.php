
<?php
if ($this->pridej) {
    ?>

    <form id="" role="form" method="post" action="spravaimei/pridej">

        <div class="form-group">
            <input id="inventuraPridejFormEan" class="form-control" pattern="[0-9]{11,13}" name="ean" title="EAN" value="" oninput="" onblur="" placeholder="EAN" required>
            <input id="inventuraSkok" type="checkbox" title="skok"  tabindex="-1" checked>
            <input id="inventuraPridejFormImei" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei" value="" placeholder="IMEI 1">
            <input id="inventuraPridejFormImei1" pattern="[0-9]{14,15}" title="IMEI" class="form-control" name="imei1" value="" placeholder="IMEI 2">
            <input type="submit">
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
                <td><a href="spravaimei/smaz/<?= $this->inventuraEan ?>/<?= $b['imei'] ?>/<?= $b['imei1'] ?>" class="btn btn-default">smaz</a></td>
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
        if (window.location.href != "http://<?= SERVERURL ?><?= PATHBASE ?>spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>") {
            window.location.replace("spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>");
            console.log("http://<?= SERVERURL ?><?= PATHBASE ?>spravaimei/<?= $this->akce ?>/<?= $this->inventuraEan ?>");
        }

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

    });

    function urlKontrola() {

        //window.location.replace("spravaimei/<?= $this->inventuraEan ?>");
    }

</script>