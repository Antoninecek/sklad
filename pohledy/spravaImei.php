
<?php
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
            <td><a href="spravaimei/<?= $this->inventuraEan ?>/<?= $b['imei'] ?>/<?= $b['imei1'] ?>/smaz" class="btn btn-default">smaz</a></td>
        </tr>
        <?php
    }
    ?>

</table>

<script type="text/javascript">

    $(document).ready(function () {
        console.log(window.location.href);
        if (window.location.href != "http://<?=SERVERURL?><?= PATHBASE ?>spravaimei/<?= $this->inventuraEan ?>") {
            window.location.replace("spravaimei/<?= $this->inventuraEan ?>");
            console.log("http://<?=SERVERURL?><?= PATHBASE ?>spravaimei/<?= $this->inventuraEan ?>");
        }
    });

    function urlKontrola() {

        //window.location.replace("spravaimei/<?= $this->inventuraEan ?>");
    }

</script>