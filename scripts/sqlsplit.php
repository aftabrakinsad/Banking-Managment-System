<?php
// Splits a SQL script into statements, respecting quotes and comments.
function split_sql($sql)
{
    $out = []; $cur = ''; $n = strlen($sql); $q = null;
    for ($i = 0; $i < $n; $i++) {
        $c = $sql[$i]; $d = $i + 1 < $n ? $sql[$i + 1] : '';
        if ($q === null) {
            if ($c === '-' && $d === '-') { while ($i < $n && $sql[$i] !== "\n") { $i++; } continue; }
            if ($c === '/' && $d === '*') { $i += 2; while ($i + 1 < $n && !($sql[$i] === '*' && $sql[$i + 1] === '/')) { $i++; } $i++; continue; }
            if ($c === "'" || $c === '"' || $c === '`') { $q = $c; $cur .= $c; continue; }
            if ($c === ';') { if (trim($cur) !== '') { $out[] = trim($cur); } $cur = ''; continue; }
            $cur .= $c;
        } else {
            $cur .= $c;
            if ($c === '\\' && $q !== '`') { $cur .= $d; $i++; continue; }
            if ($c === $q) {
                if ($d === $q) { $cur .= $d; $i++; continue; }   // doubled quote
                $q = null;
            }
        }
    }
    if (trim($cur) !== '') { $out[] = trim($cur); }
    return $out;
}
