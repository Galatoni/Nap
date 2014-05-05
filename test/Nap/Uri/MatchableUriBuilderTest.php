<?php

class MatchableUriBuilderTest extends PHPUnit_Framework_TestCase
{
    /** @test **/
    public function WhenRootResourceHasNoChildren_GeneratesOneUri()
    {
        // Arrange
        $root = new \Nap\Resource\Resource("MyResource", "/my/resource");
        $expectedRegex = "#^/my/resource$#";
        $expectedCount = 1;

        $builder  = new \Nap\Uri\MatchableUriBuilder();

        // Act
        $uris = $builder->buildUrisForResource($root);
        
        // Assert
        $this->assertEquals($expectedCount, count($uris));
        $this->assertEquals($expectedRegex, $uris[0]->getUriRegex());
    }

    /** @test **/
    public function WhenRootResourceHasOneChild_GeneratesTwoUris()
    {
        // Arrange
        $root = new \Nap\Resource\Resource("MyResource", "/my/resource", array(
            new \Nap\Resource\Resource("Child", "/child")
        ));
        $expectedRegexs = array(
            "#^/my/resource$#",
            "#^/my/resource/child$#"
        );
        $expectedCount = 2;

        $builder  = new \Nap\Uri\MatchableUriBuilder();

        // Act
        $uris = $builder->buildUrisForResource($root);

        // Assert
        $this->assertEquals($expectedCount, count($uris));
        foreach($uris as $i => $u){
            $this->assertEquals($expectedRegexs[$i], $u->getUriRegex());
        }
    }

    /** @test **/
    public function WhenRootResourceHasOneGrandChild_GeneratesThreeUris()
    {
        // Arrange
        $root = new \Nap\Resource\Resource("MyResource", "/my/resource", array(
            new \Nap\Resource\Resource("Child", "/child", array(
                new \Nap\Resource\Resource("Grandchild", "/grandchild")
            ))
        ));
        $expectedRegexs = array(
            "#^/my/resource$#",
            "#^/my/resource/child$#",
            "#^/my/resource/child/grandchild$#"
        );
        $expectedCount = 3;

        $builder  = new \Nap\Uri\MatchableUriBuilder();

        // Act
        $uris = $builder->buildUrisForResource($root);

        // Assert
        $this->assertEquals($expectedCount, count($uris));
        foreach($uris as $i => $u){
            $this->assertEquals($expectedRegexs[$i], $u->getUriRegex());
        }
    }

    /** @test **/
    public function WhenRootResourceHasTwoChildren_GeneratesThreeUris()
    {
        // Arrange
        $root = new \Nap\Resource\Resource("MyResource", "/my/resource", array(
            new \Nap\Resource\Resource("Child", "/child"),
            new \Nap\Resource\Resource("Sibling", "/sibling")
        ));
        $expectedRegexs = array(
            "#^/my/resource$#",
            "#^/my/resource/child$#",
            "#^/my/resource/sibling$#"
        );
        $expectedCount = 3;

        $builder  = new \Nap\Uri\MatchableUriBuilder();

        // Act
        $uris = $builder->buildUrisForResource($root);

        // Assert
        $this->assertEquals($expectedCount, count($uris));
        foreach($uris as $i => $u){
            $this->assertEquals($expectedRegexs[$i], $u->getUriRegex());
        }
    }
}