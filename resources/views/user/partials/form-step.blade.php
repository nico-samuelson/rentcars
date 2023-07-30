<style>
    .form-step-container {
        margin-top: 4em !important;
    }

    #form-step {
        overflow: hidden;
        margin: 0;
        padding: 0;
        position: relative;
        z-index: -10;
        /*CSS counters to number the steps*/
        counter-reset: step;
    }

    #form-step li {
        list-style-type: none;
        color: #aaa;
        font-size: 12px;
        font-weight: 600;
        text-align: center;
        width: 25%;
        float: left;
        position: relative;
    }

    #form-step li:before {
        content: counter(step);
        counter-increment: step;
        width: 30px;
        height: 30px;
        line-height: 30px;
        display: block;
        font-weight: 600;
        color: #000;
        background: #aaa;
        border-radius: 50%;
        margin: 0 auto 5px auto;
    }

    /*form-step connectors*/
    #form-step li:after {
        content: '';
        width: 70%;
        border: 1px dashed #aaa;
        position: absolute;
        left: -35%;
        top: 15px;
        z-index: -5;
    }

    #form-step li:first-child:after {
        content: none;
    }

    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #form-step li.active:before {
        background: var(--primary);
        color: #fff;
    }

    #form-step li.active:after {
        border: 1px dashed var(--primary);
        color: #aaa;
    }

    #form-step li.active {
        color: var(--primary) !important;
    }

    @media screen and (max-width:576px) {
        #form-step li {
            font-size: 9px;
        }
    }

    .form-step-container {
        position: relative;
        z-index: -10;
    }
</style>

<div class="col tile py-3 form-step-container" id="form-step">
    <ul id="form-step">
        <li class="{{ Request::is('rent/*') || Request::is('payment/create/*') ? 'active' : '' }}">Schedule</li>
        <li class="{{ !Request::is('rent/schedule') ? 'active' : ""}}">Choose Vehicle</li>
        <li class="{{ Request::is('rent/form') || Request::is('payment/create/*') ? 'active' : ''}}">Fill Detail</li>
        <li class="{{ Request::is('payment/create/*') ? 'active' : ""}}">Pay</li>
    </ul>
</div>