<?php

namespace Applicaton\PubSub;

use SplSubject;
use SplObserver;

interface EventEmitterInterface
{
    public function on(SplObserver $subscriber);
    public function removeListener(SplObserver $subscriber);
    public function removeAllListeners();
    public function emit();
}

class EventEmitter implements EventEmitterInterface, SplSubject
{
	protected $name;
	protected $data;
	protected $linked;
	protected $subscribers;
	
	public function __construct($name) 
	{
		$this->name = $name;
		$this->data = array();
		$this->subscribers = array();
		$this->linked = array();		
	}
	
	public function __toString()
	{
		return $this->name;
	}
	
	public function on (SplObserver $subscriber) {
		$this->subscribers[$subscriber->getKey()]->update($this);
	}
	
	public function attach(SplObserver $subscriber) {
		$this->subscribers[$subscriber->getKey()] = $subscriber;
		$this->linked[$subscriber->getKey()] = $subscriber->getPriority();
		arsort($this->linked);
	}
	
	public function detach(SplObserver $subscriber) {
		unset($this->subscribers[$subscriber->getKey()]);
		unset($this->linked[$subscriber->getKey()]);		
	}
	
	public function removeListener(SplObserver $subscriber) {
		unset($this->subscribers[$subscriber->getKey()]);
		unset($this->linked[$subscriber->getKey()]);		
	}
	
	public function removeAllListeners() {
		$this->subscribers = array();
		$this->linked = array();		
	}
	
	public function notify() {
		foreach ($this->linked as $key => $value) {
			$this->subscribers[$key]->update($this);
		}
	}
	
	public function emit() {
		foreach ($this->linked as $key => $value) {
			$this->subscribers[$key]->update($this);
		}
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setDataByKey($key, $value) {
		$this->data[$key] = $value;
	}

	public function getData() {
		return $this->data;
	}
	
}