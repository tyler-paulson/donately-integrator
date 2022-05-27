<?php

function di_delete_all_transients() {
    delete_transient('di_get_donately_campaigns');
}