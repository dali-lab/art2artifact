<div class="navbar" style="margin-bottom: 0px;">
    <div class="navbar-inner">
        <form class="navbar-form pull-left" name="map_options" method="post" action="timeline.php">
            From: <input type="text" name="start_date" value="Start" style="width:75px;"/>
            <select name="start_era" style="width:60px;">
                <option value="">AD</option>
                <option value="-">BCE</option>
            </select>
            | To: <input type="text" name="end_date" value="End" style="width:75px;"/>
            <select name="end_era" style="width:60px;">
                <option value="">AD</option>
                <option value="-">BCE</option>
            </select>
            | 
            <?PHP
				include "phpfunctions.php";
				$db = new SunapeeDB();
				$db->connect();
				$db->get_locations(0);
				$db->disconnect();
			?>
            <input type="hidden" name="uploaded" value="1">
            <select name="era_category" style="width: 120px;">
				<option value="era_category">Era Category</option>
                <option value="'Republican'">Republican</option>
                <option value="'Imperial'">Imperial</option>
                <option value="'Archaic'">Archaic</option>
                <option value="'Classical'">Classical</option>
                <option value="'Hellenistic'">Hellenistic</option>
            </select>
            <select name="region_category" style="width: 140px;">
				<option value="region_category">Region Category</option>
                <option value="'Greek'">Greek</option>
                <option value="'Roman'">Roman</option>
            </select>
            <button type="submit" class="btn">
                Submit
            </button>
        </form>
    </div>
</div>
