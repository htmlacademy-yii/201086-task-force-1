<?php


namespace frontend\classes;


class TimeAgo
{
    public $date;
    public $time;

    public function __construct($date, $ts = true)
    {
        $this->date = $date;
        if ($ts) {
            $this->time = time() - strtotime($this->date);
        } else {
            $this->time = time() - strtotime($this->date);
        }
    }

    private function getMinute(): int
	{
		$date = floor($this->time / 60) % 60;
		return $date;
	}

	private function getHour():int
	{
		$date = floor($this->time / 3600) % 24;
		return $date;
	}

	private function getDays():int
	{
		$date = floor($this->time / 3600 / 24) % 30;
		return $date;
	}

	private function getWeek():int
	{
		$date = intdiv(floor($this->time / 3600 / 24), 7);
		return $date;
	}

	private function getMonth():int
	{
		$date = floor($this->time / 3600 / 24 / 30) % 12 ;
		return $date;
	}

	private function getYear():int
	{
		$date = floor($this->time / 3600/24/365) ;
		return $date;
	}

	public function getDate():string
	{
		if ($this->getYear() > 0){
			return $this->getYear() .' '. (new NumericFormatter($this->getYear(), 'years'))->getWord();
		}
		if ($this->getMonth() > 0){
			return $this->getMonth().' '. (new NumericFormatter($this->getMonth(), 'months'))->getWord();
		}
		if ($this->getWeek() > 0){
			return $this->getWeek().' '. (new NumericFormatter($this->getWeek(), 'week'))->getWord();
		}
		if ($this->getDays() > 0){
			return $this->getDays().' '. (new NumericFormatter($this->getDays(), 'days'))->getWord();
		}
		if ($this->getHour() > 0){
			return $this->getHour().' '. (new NumericFormatter($this->getHour(), 'hours'))->getWord();
		}
		return	$this->getMinute().' '. (new NumericFormatter($this->getMinute(), 'minutes'))->getWord();
	}
}