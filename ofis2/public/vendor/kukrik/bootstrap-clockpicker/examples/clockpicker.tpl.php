<?php require(QCUBED_CONFIG_DIR . '/header.inc.php'); ?>
    <style >
        body {font-size: medium;}
        p, footer {font-size: medium;}
    </style>

<?php $this->RenderBegin(); ?>

    <div class="instructions">
        <h1 class="instruction_title">Bootstrap ClockPicker some usage examples</h1>
        <p>The ClockPicker plugin allows to you use the Clock Picker, which is a Bootstrap
            form component to handle time data, on your forms.</p>

        <p>Home page for the lib is <a href="https://github.com/weareoutman/clockpicker">https://github.com/weareoutman/clockpicker</a>
            and demo is at <a href="http://weareoutman.github.io/clockpicker/">http://weareoutman.github.io/clockpicker/</a>,
            where you can see example of use.</p>
    </div>

    <div class="form-horizontal" style="padding-top: 25px;">

        <div class="form-group">
            <label class="col-sm-2 control-label">Time Picking</label>
            <div class="col-sm-3">
                <?= _r($this->clockpicker1); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output the database through the QDateTime class in the time format: <?= _r($this->label1); ?></p>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Time Picking</label>
            <div class="col-sm-3">
                <?= _r($this->clockpicker2); ?>
            </div>
            <p style="padding-top: 6px; display: inline-block;">Output the database through the QDateTime class in the time format: <?= _r($this->label2); ?></p>
        </div>

    </div>

<?php $this->RenderEnd(); ?>

<?php require(QCUBED_CONFIG_DIR . '/footer.inc.php'); ?>