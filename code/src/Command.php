<?php

namespace IraYu\OtusHw4;

interface Command
{
    public function execute(Request $request): Result;
}