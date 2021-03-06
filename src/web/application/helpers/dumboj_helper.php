<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//0th bit of privilege
if (!function_exists('can_admin')) {
    function can_admin($privilege) {
        return is_int($privilege) && (($privilege >> 0) & 1) === 1;
    }
}

//1st bit of privilege
if (!function_exists('can_view_code')) {
    function can_view_code($privilege) {
        return is_int($privilege) && (($privilege >> 1) & 1) === 1;
    }
}

//2nd bit of privilege
if (!function_exists('can_hide')) {
    function can_hide($privilege) {
        return is_int($privilege) && (($privilege >> 2) & 1) === 1;
    }
}

if (!function_exists('generate_salt')) {
    function generate_salt($length = 8) {
        $table = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $salt = '';
        for ($i = 0; $i < $length; ++$i) {
            $salt .= $table{mt_rand(0, 35)};
        }
        return $salt;
    }
}

if (!function_exists('get_available_sites')) {
    function get_available_sites() {
        //Could add more sites here.
        return array(
            '' => 'All',
            'http://poj.org' => 'POJ',
            'http://acm.hdu.edu.cn' => 'HDU',
            'http://acm.whu.edu.cn/land' => 'WOJ',
            'https://icpcarchive.ecs.baylor.edu' => 'LiveArchive'
        );
    }
}

if (!function_exists('get_available_languages')) {
    function get_available_languages($site) {
        //Could add more languages here.
        switch ($site) {
            case 'POJ':
                return array(
                    0 => 'G++',
                    1 => 'GCC',
                    2 => 'Java',
                    3 => 'Pascal',
                    4 => 'C++',
                    5 => 'C',
                    6 => 'Fortran'
                );
            case 'HDU':
                return array(
                    0 => 'G++',
                    1 => 'GCC',
                    2 => 'C++',
                    3 => 'C',
                    4 => 'Pascal',
                    5 => 'Java'
                );
            case 'WOJ':
                return array(
                    1 => 'C',
                    2 => 'C++',
                    3 => 'Java',
                    4 => 'Pascal'
                );
            case 'LiveArchive':
                return array(
                    1 => 'ANSI C 4.1.2',
                    2 => 'JAVA 1.6.0',
                    3 => 'C++ 4.1.2',
                    4 => 'PASCAL 2.0.4'
                );
            default:
                return array();
        }
    }
}

if (!function_exists('get_all_results')) {
    function get_all_results() {
        //Could add more results here.
        return array(
            '' => 'All',
            0 => 'Accepted',
            1 => 'Wrong Answer',
            2 => 'Time Limit Exceeded',
            3 => 'Memory Limit Exceeded',
            4 => 'Output Limit Exceeded',
            5 => 'Compile Error',
            6 => 'Presentation Error',
            7 => 'Runtime Error',
            8 => 'Restricted Function',
            16 => 'System Error'
        );
    }
}

if (!function_exists('get_all_languages')) {
    function get_all_languages() {
        //Could add more languages here.
        return array(
            '' => 'All',
            0 => 'C',
            1 => 'C++',
            2 => 'Pascal',
            3 => 'Java',
            4 => 'Fortran'
        );
    }
}

if (!function_exists('get_result_key')) {
    function get_result_key($result) {
        $result = strtolower(preg_replace('/\W/', '', $result));
        if (strpos($result, 'accepted') !== false) {
            return 0;
        }
        if (strpos($result, 'wronganswer') !== false) {
            return 1;
        }
        if (strpos($result, 'timelimitexceeded') !== false) {
            return 2;
        }
        if (strpos($result, 'memorylimitexceeded') !== false) {
            return 3;
        }
        if (strpos($result, 'outputlimitexceeded') !== false) {
            return 4;
        }
        if (strpos($result, 'compileerror') !== false || strpos($result, 'compilationerror') !== false) {
            return 5;
        }
        if (strpos($result, 'presentationerror') !== false) {
            return 6;
        }
        if (strpos($result, 'runtimeerror') !== false) {
            return 7;
        }
        if (strpos($result, 'restrictedfunction') !== false) {
            return 8;
        }
        if (strpos($result, 'systemerror') !== false || strpos($result, 'dumbjudgeerror') !== false || strpos($result, 'submissionerror') !== false/*TODO || strpos($result, 'cantbejudged') !== false*/) {
            return 16;
        }
        return -1;
    }
}

if (!function_exists('get_language_key')) {
    function get_language_key($language) {
        switch (strtolower(trim($language))) {
            case 'c': case 'gcc': case 'ansi c 4.1.2':
                return 0;
            case 'c++': case 'g++': case'c++ 4.1.2':
                return 1;
            case 'pascal': case'pascal 2.0.4':
                return 2;
            case 'java': case'java 1.6.0':
                return 3;
            case 'fortran':
                return 4;
            default:
                return -1;
        }
    }
}

if (!function_exists('get_brush')) {
    function get_brush($language) {
        switch ((int)$language) {
            case get_language_key('C'): case get_language_key('C++'):
                return 'brush: cpp';
            case get_language_key('Pascal'):
                return 'brush: pascal';
            case get_language_key('Java'):
                return 'brush: java';
            default:
                return '';
        }
    }
}

if (!function_exists('nullable_input')) {
    function nullable_input($input) {
        return $input === false || trim($input) === '' ? null : $input;
    }
}

if (!function_exists('parse_conditions')) {
    function parse_conditions($value, $names, $separator = ':') {
        $result = array();
        if (substr_count($value, $separator) !== count($names) - 1) {
            return $result;
        }
        $values = explode($separator, $value);
        for ($i = 0; $i < count($values); ++$i) {
            if ($values[$i] !== '') {
                $result[$names[$i]] = $values[$i];
            }
        }
        return $result;
    }
}

if (!function_exists('get_contest_status')) {
    function get_contest_status($start_time, $end_time, $now = null) {
        if (!($start_time instanceof DateTime)) {
            $start_time = new DateTime($start_time);
        }
        if (!($end_time instanceof DateTime)) {
            $end_time = new DateTime($end_time);
        }
        if ($now === null) {
            $now = new DateTime();
        } else if (!($now instanceof DateTime)) {
            $now = new DateTime($now);
        }
        if ($now < $start_time) {
            return 'Upcoming';
        } else if ($now < $end_time) {
            return 'Running';
        } else {
            return 'Ended';
        }
    }
}

if (!function_exists('get_time_span')) {
    function get_time_span($start_time, $end_time) {
        if (!($start_time instanceof DateTime)) {
            $start_time = new DateTime($start_time);
        }
        if (!($end_time instanceof DateTime)) {
            $end_time = new DateTime($end_time);
        }
        return $end_time->getTimestamp() - $start_time->getTimestamp();
    }
}

/* End of file dumboj_helper.php */
/* Location: ./application/helpers/dumboj_helper.php */
?>
