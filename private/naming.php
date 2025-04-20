<?php
/*
 * MIT License
 *
 * Copyright (c) 2022- Minteck
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

function generateName() {
    $animals = [
        "cat",
        "dog",
        "fox",
        "squirrel",
        "rabbit",
        "kit",
        "vixen",
        "wildcat",
        "weasel",
        "kitty",
        "kitten",
        "doe",
        "buck",
        "fawn",
        "dear",
        "calf",
        "falcon",
        "pup",
        "hedgehog",
        "jellyfish",
        "koala",
        "otter",
        "raccoon",
        "panda",
        "wolf"
    ];
    $adjectives = [
        "aerial",
        "sensuous",
        "astragalar",
        "tactic",
        "infantile",
        "meline",
        "big",
        "small",
        "fancy",
        "beautiful",
        "curious",
        "feline",
        "canine",
        "wild",
        "old",
        "young",
        "fraternal",
        "calm",
        "cosy",
        "mental",
        "juvenile",
        "cupric",
        "forensic",
        "auroral",
        "twilight",
        "cervine",
        "rucervine",
        "ethereal",
        "final",
        "paternal",
        "digital",
        "vulpine",
        "lapidary",
        "spectral",
        "thermal",
        "caloric",
        "manual",
        "insular",
        "mechanical",
        "virile",
        "specular",
        "nominal",
        "cervical",
        "strigine",
        "oceanic",
        "aquatic",
        "fire",
        "lagomorphic",
        "pluvial",
        "fluvial",
        "nautical",
        "acoustic",
        "superficial",
        "solar",
        "starry",
        "caudal",
        "lupine",
        "wolven",
        "vinic"
    ];

    $number = bin2hex(random_bytes(3));
    $adjective = $adjectives[rand(0, count($adjectives) - 1)];
    $animal = $animals[rand(0, count($animals) - 1)];
    $first = substr($animal, 0, 1);

    $props = [];
    foreach ($adjectives as $a) {
        if (substr($a, 0, 1) === $first) {
            array_push($props, $a);
        }
    }

    if (count($props) > 0) {
        $adjective = $props[rand(0, count($props) - 1)];
    }

    return $adjective . "-" . $animal . "-" . $number;
}