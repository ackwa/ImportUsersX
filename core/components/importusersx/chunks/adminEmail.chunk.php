<p>Hello,</p>

    [[+addCount:gt=`0`:then=`<p>[[+addCount]] account[[+addCount:gt=`1`:then=`s`:else=``]] has been created : </p>
    	<p>[[+addLog]]</p><br/>`:else=``]]

	[[+changeCount:gt=`0`:then=`<p>[[+changeCount]] account[[+changeCount:gt=`1`:then=`s`:else=``]] has been changed : </p>
    	<p>[[+changeLog]]</p><br/>`:else=``]]