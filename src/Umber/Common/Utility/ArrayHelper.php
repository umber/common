<?php

declare(strict_types=1);

namespace Umber\Common\Utility;

final class ArrayHelper
{
    /**
     * A custom filter that cleanses arrays and nulls.
     *
     * @param mixed[] $data
     *
     * @return mixed[]
     */
    public static function filter(array $data): array
    {
        $filtered = [];

        if (count($data) === 0) {
            return [];
        }

        foreach ($data as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_array($value)) {
                $value = self::filter($value);

                if (count($value) === 0) {
                    continue;
                }
            }

            $filtered[$key] = $value;
        }

        return $filtered;
    }
}
