<?php
	class BBCodeTest extends CTestCase{
		private function process($bbCode){
			$bb = new EBBCode();
			return $bb->process($bbCode);
		}
		
		function testSingleTags(){
			$this->assertEquals('<strong>test</strong>',$this->process('[b]test[/b]'));
			$this->assertEquals('<em>test</em>',$this->process('[i]test[/i]'));
		}
		
		function testMultipleTags(){
			$this->assertEquals('<strong>test</strong> <em>test</em>',$this->process('[b]test[/b] [i]test[/i]'));
		}
	}