<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class PublicationDateSortDirectionFunctionTest extends TestCase
{
    /** @test */
    public function must_return_asc_when_provided_with_oldest_string_as_input
    (): void
    {
        $sort_direction = publication_date_sort_direction('oldest');

        $this->assertEquals('asc', $sort_direction);
    }

    /** @test */
    public function
    must_return_desc_when_provided_with_newest_string_as_input(): void
    {
        $sort_direction = publication_date_sort_direction('newest');

        $this->assertEquals('desc', $sort_direction);
    }

    /** @test */
    public function must_return_desc_when_provided_any_other_input(): void
    {
        $invalid_inputs = ['', 'test', 'unknown', 'demo'];

        foreach ($invalid_inputs as $input) {
            $sort_direction = publication_date_sort_direction($input);

            $this->assertEquals('desc', $sort_direction);
        }
    }
}
