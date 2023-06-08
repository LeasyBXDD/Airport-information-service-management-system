<template>
<h1 id='系统数据库设计'>系统数据库设计</h1>
<p>李奕哲 2021212205098</p>
<h2 id='一系统需求分析'>一、系统需求分析</h2>
<h3 id='11-系统功能需求'>1.1 系统功能需求</h3>
<p>本系统是一个航班预订系统，用于管理客户、航班、预订、座位和飞机的信息。</p>
<p>我为该系统设计了以下几个功能：</p>
<ol>
<li><strong>查询航班</strong>：根据客户输入的出发地、目的地、日期等条件，在Flight表中查找符合要求的航班，并显示相关信息（如航班号、出发时间、到达时间、状态等）给客户。查询条件可以为空或多个。查询结果可以为空或多个。查询结果可以按照不同维度（如价格、时间、状态等）排序或筛选。查询结果可以选择或取消选择。查询结果可以返回或继续查询。查询结果可以修改或删除。查询结果可以与其他查询结果比较或合并。查询结果可以作为输入参数传递给其他功能元素（如预订航班、查看座位等）。</li>
<li><strong>查看座位</strong>：根据客户选择或输入的航班号，在Seat表和ReservationSeatAssignment表中查找该航班对应飞机上所有座位及其状态（如已预订、未预订、不可用等），并以图形或列表形式显示给客户。显示信息包括座位编号、类型（如头等舱、经济舱等）、价格等。显示信息可以按照不同维度（如类型、价格、位置等）排序或筛选。显示信息可以选择或取消选择。显示信息可以返回或继续查看。显示信息可以修改或删除。显示信息可以与其他显示信息比较或合并。显示信息可以作为输入参数传递给其他功能元素（如预订座位等）。</li>
<li><strong>预订座位</strong>：根据客户选择或输入的座位号，在Reservation表和ReservationSeatAssignment表中创建新记录，并更新相应座位状态为已预订。创建记录时需要验证客户身份和支付方式，并确认预订信息（如客户姓名、联系方式、航班号、出发时间、到达时间、座位号等）。创建记录后需要生成预订号，并将其与其他预订信息一起显示给客户。显示信息可以返回或继续预订。显示信息可以修改或删除。显示信息可以与其他显示信息比较或合并。</li>
<li><strong>管理客户</strong>：在Customer表中添加、修改或删除客户记录，并提供相应接口供其他功能元素调用（如验证客户身份、获取客户联系方式等）。</li>
<li><strong>管理航班</strong>：在Flight表中添加、修改或删除航班记录，并提供相应接口供其他功能元素调用（如获取航班信息、更新航班状态等）。</li>
<li><strong>管理飞机</strong>：在Aircraft表中添加、修改或删除飞机记录，并提供相应接口供其他功能元素调用（如获取飞机类型、获取飞机座位数目等）。</li>
<li><strong>管理机场</strong>：在Airport表中添加、修改或删除机场记录，并提供相应接口供其他功能元素调用（如获取机场代码、获取机场名称等）。</li>
<li><strong>管理数据库</strong>：对FlightReservation数据库进行备份、恢复、优化等操作，并提供相应接口供其他功能元素调用（如连接数据库、执行SQL语句等）。</li>

</ol>
<p>&nbsp;</p>
<figure class='table-figure'><table>
<thead>
<tr><th>  <strong>表名</strong>  </th><th>  <strong>字段名</strong>  </th><th>  <strong>数据类型</strong>  </th><th>  <strong>约束条件</strong>  </th></tr></thead>
<tbody><tr><td>  <strong>Customer</strong>  </td><td>  CustomerID  </td><td>  INT  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  Name  </td><td>  VARCHAR(50)  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  ContactInfo  </td><td>  VARCHAR(100)  </td><td>     </td></tr><tr><td>  <strong>Flight</strong>  </td><td>  FlightID  </td><td>  INT  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  FlightNumber  </td><td>  VARCHAR(10)  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  DepartureTime  </td><td>  DATETIME  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  ArrivalTime  </td><td>  DATETIME  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  FlightStatus  </td><td>  VARCHAR(20)  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  AircraftID  </td><td>  INT  </td><td>  NOT NULL, FOREIGN KEY  REFERENCES Aircraft(AircraftID)  </td></tr><tr><td>     </td><td>  DepartureAirportCode  </td><td>  CHAR(3)  </td><td>     </td></tr><tr><td>     </td><td>  DepartureAirportName  </td><td>  VARCHAR(50)  </td><td>     </td></tr><tr><td>     </td><td>  ArrivalAirportCode  </td><td>  CHAR(3)  </td><td>     </td></tr><tr><td>     </td><td>  ArrivalAirportName  </td><td>  VARCHAR(50)  </td><td>     </td></tr><tr><td>  <strong>Reservation</strong>  </td><td>  ReservationID  </td><td>  INT  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  CustomerID  </td><td>  INT  </td><td>  NOT NULL, FOREIGN KEY  REFERENCES Customer(CustomerID)  </td></tr><tr><td>     </td><td>  FlightID  </td><td>  INT  </td><td>  NOT NULL, FOREIGN KEY  REFERENCES Flight(FlightID)  </td></tr><tr><td>     </td><td>  ReservationDate  </td><td>  DATE  </td><td>  NOT NULL  </td></tr><tr><td>  <strong>Seat</strong>  </td><td>  SeatID  </td><td>  INT  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  AircraftID  </td><td>  INT  </td><td>  NOT NULL, FOREIGN KEY  REFERENCES Aircraft(AircraftID)  </td></tr><tr><td>     </td><td>  SeatNumber  </td><td>  VARCHAR(5)  </td><td>  NOT NULL  </td></tr><tr><td>  <strong>Aircraft</strong>  </td><td>  AircraftID  </td><td>  INT  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  AircraftType  </td><td>  VARCHAR(20)  </td><td>  NOT NULL  </td></tr><tr><td>     </td><td>  NumberOfSeats  </td><td>  INT  </td><td>  NOT NULL  </td></tr><tr><td>  <strong>Airport</strong>  </td><td>  AirportCode  </td><td>  CHAR(3)  </td><td>  PRIMARY KEY  </td></tr><tr><td>     </td><td>  AirportName  </td><td>  VARCHAR(50)  </td><td>  NOT NULL  </td></tr><tr><td>  <strong>ReservationSeatAssignment</strong>  </td><td>  ReservationID  </td><td>  INT  </td><td>  PRIMARY KEY, FOREIGN KEY  REFERENCES Reservation(ReservationID)  </td></tr><tr><td>     </td><td>  SeatID  </td><td>  INT  </td><td>  PRIMARY KEY, FOREIGN KEY  REFERENCES Seat(SeatID)  </td></tr><tr><td>     </td><td>  FlightID  </td><td>  INT  </td><td>  PRIMARY KEY, FOREIGN KEY REFERENCES  Flight(FlightID)  </td></tr></tbody>
</table></figure>
<p>&nbsp;</p>
<h3 id='12-数据需求分析'>1.2 数据需求分析</h3>
<ol>
<li>客户数据：包括客户的标识符、姓名和联系方式，用于识别和联系客户。</li>
<li>航班数据：包括航班的标识符、编号、出发时间、到达时间、状态、飞机标识符、出发机场代码和名称、到达机场代码和名称，用于显示和查询航班信息。</li>
<li>预订数据：包括预订的标识符、客户标识符、航班标识符和预订日期，用于记录和管理客户的预订信息。</li>
<li>座位数据：包括座位的标识符、飞机标识符和座位编号，用于显示和分配座位信息。</li>
<li>飞机数据：包括飞机的标识符、类型和座位数目，用于描述和管理飞机信息。</li>
<li>机场数据：包括机场的代码和名称，用于描述和查询机场信息。</li>
<li>预订座位分配数据：包括预订标识符、座位标识符和航班标识符，用于记录和管理预订的座位分配信息。</li>

</ol>
<p>&nbsp;</p>
<h2 id='二概念结构设计'>二、概念结构设计</h2>
<p><img src="../../public/er.png" referrerpolicy="no-referrer" alt="img"></p>
<h2 id='三逻辑结构设计'>三、逻辑结构设计</h2>
<h3 id='31-关系模式'>3.1 关系模式</h3>
<ol>
<li>Customer(CustomerID, Name, ContactInfo)</li>

</ol>
<p>–  CustomerID是主键，表示客户的唯一标识符。</p>
<p>–  Name是非空属性，表示客户的姓名。</p>
<p>–  ContactInfo是可空属性，表示客户的联系方式，如电话、邮箱等。</p>
<ol start='2' >
<li>Flight(FlightID, FlightNumber, DepartureTime, ArrivalTime, FlightStatus, AircraftID, DepartureAirportCode, DepartureAirportName, ArrivalAirportCode, ArrivalAirportName)</li>

</ol>
<p>–  FlightID是主键，表示航班的唯一标识符。</p>
<p>–  FlightNumber是非空属性，表示航班的编号，如CA1234。</p>
<p>–  DepartureTime是非空属性，表示航班的出发时间，如2021-05-22 14:00:00。</p>
<p>–  ArrivalTime是非空属性，表示航班的到达时间，如2021-05-22 16:00:00。</p>
<p>–  FlightStatus是非空属性，表示航班的状态，如正常、延误、取消等。</p>
<p>–  AircraftID是非空属性，表示航班使用的飞机的标识符，引用Aircraft表的AircraftID属性。</p>
<p>–  DepartureAirportCode是可空属性，表示航班出发机场的代码，如PEK。</p>
<p>–  DepartureAirportName是可空属性，表示航班出发机场的名称，如北京首都国际机场。</p>
<p>–  ArrivalAirportCode是可空属性，表示航班到达机场的代码，如SHA。</p>
<p>–  ArrivalAirportName是可空属性，表示航班到达机场的名称，如上海虹桥国际机场。</p>
<ol start='3' >
<li>Reservation(ReservationID, CustomerID, FlightID, ReservationDate)</li>

</ol>
<p>–  ReservationID是主键，表示预订的唯一标识符。</p>
<p>–  CustomerID是非空属性，表示预订客户的标识符，引用Customer表的CustomerID属性。</p>
<p>–  FlightID是非空属性，表示预订航班的标识符，引用Flight表的FlightID属性。</p>
<p>–  ReservationDate是非空属性，表示预订日期，如2021-05-22。</p>
<ol start='4' >
<li>Seat(SeatID, AircraftID, SeatNumber)</li>

</ol>
<p>–  SeatID是主键，表示座位的唯一标识符。</p>
<p>–  AircraftID是非空属性，表示座位所属飞机的标识符，引用Aircraft表的AircraftID属性。</p>
<p>–  SeatNumber是非空属性，表示座位编号，如1A、2B等。</p>
<ol start='5' >
<li>Aircraft(AircraftID, AircraftType, NumberOfSeats)</li>

</ol>
<p>–  AircraftID是主键，表示飞机的唯一标识符。</p>
<p>–  AircraftType是非空属性，表示飞机类型，如波音737、空客320等。</p>
<p>–  NumberOfSeats是非空属性，表示飞机座位数目，如180、200等。</p>
<ol start='6' >
<li>Airport(AirportCode, AirportName)</li>

</ol>
<p>–  AirportCode是主键，表示机场代码，如PEK、SHA等。</p>
<p>–  AirportName是非空属性，表示机场名称，如北京首都国际机场、上海虹桥国际机场等。</p>
<ol start='7' >
<li>ReservationSeatAssignment(ReservationID, SeatID, FlightID)</li>

</ol>
<p>–  (ReservationID, SeatID, FlightID)是主键，表示预订座位分配的唯一标识符。</p>
<p>–  ReservationID是非空属性，表示预订标识符，引用Reservation表的ReservationID属性。</p>
<p>–  SeatID是非空属性，表示座位标识符，引用Seat表的SeatID属性。</p>
<p>–  FlightID是非空属性，表示航班标识符，引用Flight表的FlightID属性。</p>
<p>&nbsp;</p>
<h3 id='32-关系规范化分析'>3.2 关系规范化分析</h3>
<p>本系统中每个关系模式都没有部分函数依赖和传递函数依赖，满足第三范式（3NF）的要求。</p>
<p>•   Customer(CustomerID, Name, ContactInfo)：CustomerID是主键，Name和ContactInfo只依赖于CustomerID，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   Flight(FlightID, FlightNumber, DepartureTime, ArrivalTime, FlightStatus, AircraftID, DepartureAirportCode, DepartureAirportName, ArrivalAirportCode, ArrivalAirportName)：FlightID是主键，其他属性只依赖于FlightID，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   Reservation(ReservationID, CustomerID, FlightID, ReservationDate)：ReservationID是主键，其他属性只依赖于ReservationID，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   Seat(SeatID, AircraftID, SeatNumber)：SeatID是主键，其他属性只依赖于SeatID，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   Aircraft(AircraftID, AircraftType, NumberOfSeats)：AircraftID是主键，其他属性只依赖于AircraftID，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   Airport(AirportCode, AirportName)：AirportCode是主键，AirportName只依赖于AirportCode，没有部分函数依赖或传递函数依赖，满足3NF。</p>
<p>•   ReservationSeatAssignment(ReservationID, SeatID, FlightID)：(ReservationID, SeatID, FlightID)是主键，没有其他非主属性，不存在任何函数依赖，满足3NF。</p>
<p>&nbsp;</p>
<h2 id='四系统使用手册'>四、系统使用手册</h2>
<h3 id='41-系统功能'>4.1 系统功能</h3>
<p>•   查询航班：根据客户输入的出发地、目的地、日期等条件，在Flight表中查找符合要求的航班，并显示相关信息（如航班号、出发时间、到达时间、状态等）给客户。</p>
<p>•   查看座位：根据客户选择或输入的航班号，在Seat表和ReservationSeatAssignment表中查找该航班对应飞机上所有座位及其状态（如已预订、未预订、不可用等），并以图形或列表形式显示给客户。</p>
<p>•   预订座位：根据客户选择或输入的座位号，在Reservation表和ReservationSeatAssignment表中创建新记录，并更新相应座位状态为已预订。</p>
<p>•   管理客户：在Customer表中添加、修改或删除客户记录，并提供相应接口供其他功能元素调用（如验证客户身份、获取客户联系方式等）。</p>
<p>•   管理航班：在Flight表中添加、修改或删除航班记录，并提供相应接口供其他功能元素调用（如获取航班信息、更新航班状态等）。</p>
<p>•   管理飞机：在Aircraft表中添加、修改或删除飞机记录，并提供相应接口供其他功能元素调用（如获取飞机类型、获取飞机座位数目等）。</p>
<p>•   管理机场：在Airport表中添加、修改或删除机场记录，并提供相应接口供其他功能元素调用（如获取机场代码、获取机场名称等）。</p>
<p>•   管理数据库：对FlightReservation数据库进行备份、恢复、优化等操作，并提供相应接口供其他功能元素调用（如连接数据库、执行SQL语句等）。</p>
<p>&nbsp;</p>
<h3 id='42-操作步骤'>4.2 操作步骤</h3>
<h4 id='1-查询航班'>1. 查询航班</h4>
<p>查询航班功能可以帮助用户根据自己的需求，快速找到合适的航班。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“查询航班”按钮，进入查询条件输入界面。</li>
<li>在查询条件输入界面，输入或选择出发地、目的地、日期等条件，可以输入或选择多个条件，也可以不输入或选择任何条件。如果不输入或选择任何条件，则表示查询所有航班。点击“查询”按钮，开始查询。</li>
<li>查询完成后，系统会在查询结果显示界面，显示符合条件的航班信息，包括航班号、出发时间、到达时间、状态等。如果没有符合条件的航班，则显示“没有找到符合条件的航班，请更改查询条件重试”。</li>
<li>在查询结果显示界面，用户可以对查询结果进行以下操作：</li>

</ol>
<p>–  排序或筛选：点击“排序”或“筛选”按钮，选择不同维度（如价格、时间、状态等），对查询结果进行排序或筛选。排序后，查询结果会按照所选维度的升序或降序排列。筛选后，查询结果会只显示符合所选维度的值的航班。</p>
<p>–  选择或取消选择：点击每个航班信息前面的复选框，可以选择或取消选择该航班。选择后，该航班会被标记为已选，并可以作为输入参数传递给其他功能元素（如预订航班、查看座位等）。取消选择后，该航班会被标记为未选，并不会作为输入参数传递给其他功能元素。</p>
<p>–  返回或继续查询：点击“返回”按钮，可以返回到查询条件输入界面，修改或清空查询条件，并重新查询。点击“继续查询”按钮，可以在当前查询结果的基础上，添加或修改查询条件，并重新查询。重新查询后，原来的查询结果会被覆盖。</p>
<p>–  修改或删除：点击每个航班信息后面的“修改”或“删除”按钮，可以修改或删除该航班。修改时，可以更改该航班的任何属性（如出发时间、到达时间、状态等），并点击“确认”按钮保存更改。删除时，需要点击“确认”按钮确认删除操作。修改或删除后，该航班在Flight表中相应的记录也会被修改或删除。</p>
<p>&nbsp;</p>
<h4 id='2-查看座位'>2. 查看座位</h4>
<p>查看座位功能可以帮助用户根据自己选择或输入的航班号，在Seat表和ReservationSeatAssignment表中查找该航班对应飞机上所有座位及其状态（如已预订、未预订、不可用等）。</p>
<ol>
<li>打开系统主界面，点击“查看座位”按钮，进入航班号输入界面。</li>
<li>在航班号输入界面，输入或选择一个有效的航班号，并点击“查看”按钮。如果没有输入或选择任何航班号，则显示“请输入或选择一个有效的航班号”。</li>
<li>查看完成后，系统会在显示该航班对应飞机上所有座位及其状态，包括座位编号、类型（如头等舱、经济舱等）、价格等。如果没有找到任何座位，则显示“该航班没有可用的座位，请选择其他航班”。</li>
<li>在座位显示界面，用户可以对座位信息进行以下操作：</li>

</ol>
<p>–  排序或筛选：点击“排序”或“筛选”按钮，选择不同维度（如类型、价格、位置等），对座位信息进行排序或筛选。排序后，座位信息会按照所选维度的升序或降序排列。筛选后，座位信息会只显示符合所选维度的值的座位。</p>
<p>–  选择或取消选择：点击每个座位信息前面的复选框，可以选择或取消选择该座位。选择后，该座位会被标记为已选，并可以作为输入参数传递给其他功能元素（如预订座位等）。取消选择后，该座位会被标记为未选，并不会作为输入参数传递给其他功能元素。</p>
<p>–  修改或删除：点击每个座位信息后面的“修改”或“删除”按钮，可以修改或删除该座位。修改时，可以更改该座位的任何属性（如类型、价格、状态等），并点击“确认”按钮保存更改。删除时，需要点击“确认”按钮确认删除操作。修改或删除后，该座位在Seat表和ReservationSeatAssignment表中相应的记录也会被修改或删除。</p>
<p>&nbsp;</p>
<h4 id='3-预订座位'>3. 预订座位</h4>
<p>预订座位功能可以帮助用户根据自己选择或输入的座位号，在Reservation表和ReservationSeatAssignment表中创建新记录，并更新相应座位状态为已预订。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“预订座位”按钮，进入预订条件输入界面。</li>
<li>在预订条件输入界面，输入或选择一个有效的客户号和一个有效的航班号，并点击“预订”按钮。如果没有输入或选择任何客户号或航班号，则显示“请输入或选择一个有效的客户号和一个有效的航班号”。如果输入或选择了一个无效的客户号或航班号，则显示“客户号或航班号不存在，请重新输入或选择”。</li>
<li>预订完成后，系统会显示该航班对应飞机上所有可用的座位，并让用户选择一个或多个座位。如果没有任何可用的座位，则显示“该航班没有可用的座位，请选择其他航班”。</li>
<li>在座位选择界面，用户可以对座位信息进行以下操作：</li>

</ol>
<p>–  排序或筛选：点击“排序”或“筛选”按钮，选择不同维度（如类型、价格、位置等），对座位信息进行排序或筛选。排序后，座位信息会按照所选维度的升序或降序排列。筛选后，座位信息会只显示符合所选维度的值的座位。</p>
<p>–  选择或取消选择：点击每个座位信息前面的复选框，可以选择或取消选择该座位。选择后，该座位会被标记为已选，并可以作为输入参数传递给其他功能元素（如确认预订等）。取消选择后，该座位会被标记为未选，并不会作为输入参数传递给其他功能元素。</p>
<p>–  修改或删除：点击每个座位信息后面的“修改”或“删除”按钮，可以修改或删除该座位。修改时，可以更改该座位的任何属性（如类型、价格、状态等），并点击“确认”按钮保存更改。删除时，需要点击“确认”按钮确认删除操作。修改或删除后，该座位在Seat表和ReservationSeatAssignment表中相应的记录也会被修改或删除。</p>
<ol start='5' >
<li>在完成选择后，用户需要点击“确认预订”按钮，进入预订确认界面。</li>
<li>在预订确认界面，系统会显示用户已经选择的客户号、航班号和座位号，并要求用户确认。</li>
<li>确认后，系统会在Reservation表和ReservationSeatAssignment表中创建新记录，并更新相应座位状态为已预订。系统还会生成一个唯一的预订号，并将其与其他预订信息一起显示给用户。显示信息包括客户姓名、联系方式、航班号、出发时间、到达时间、座位号等。</li>
<li>在完成预订后，用户可以对预订信息进行以下操作：</li>

</ol>
<p>–  修改或删除：点击每个预订信息后面的“修改”或“删除”按钮，可以修改或删除该预订。修改时，可以更改该预订的任何属性（如客户号、航班号、座位号、支付方式等），并点击“确认”按钮保存更改。删除时，需要点击“确认”按钮确认删除操作。修改或删除后，该预订在Reservation表和ReservationSeatAssignment表中相应的记录也会被修改或删除，并更新相应座位状态为未预订。</p>
<p>&nbsp;</p>
<h4 id='4-管理客户'>4. 管理客户</h4>
<p>管理客户功能可以帮助用户在Customer表中添加、修改或删除客户记录，并提供相应接口供其他功能元素调用（如验证客户身份、获取客户联系方式等）。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“管理客户”按钮，进入客户管理界面。</li>
<li>在客户管理界面，系统会显示Customer表中所有客户的信息，包括客户号、姓名、联系方式等。用户可以对客户信息进行以下操作：</li>

</ol>
<p>–  添加：点击“添加”按钮，进入添加客户界面，在该界面输入一个新的客户号和其他必要的属性（如姓名、联系方式等），并点击“确认”按钮。如果没有输入任何属性，则显示“请输入必要的属性”。如果输入了一个已存在的客户号，则显示“客户号已存在，请重新输入”。如果输入了一个新的且有效的客户号和其他必要的属性，则在Customer表中创建新记录，并返回到客户管理界面。</p>
<p>–  修改：点击每个客户信息后面的“修改”按钮，进入修改客户界面，在该界面更改该客户的任何属性（如姓名、联系方式等），并点击“确认”按钮。如果没有更改任何属性，则显示“没有更改任何属性”。如果更改了任何属性，则在Customer表中更新相应记录，并返回到客户管理界面。</p>
<p>–  删除：点击每个客户信息后面的“删除”按钮，需要点击“确认”按钮确认删除操作。如果确认删除，则在Customer表中删除相应记录，并返回到客户管理界面。</p>
<p>–  查询：点击“查询”按钮，进入查询条件输入界面，在该界面输入或选择一个或多个查询条件（如姓名、联系方式等），并点击“查询”按钮。如果没有输入或选择任何查询条件，则显示“请输入或选择一个或多个查询条件”。如果输入或选择了一个或多个查询条件，则在Customer表中查找符合条件的客户，并显示相关信息给用户。用户可以对查询结果进行排序、筛选操作。</p>
<p>&nbsp;</p>
<h4 id='5-管理航班'>5. 管理航班</h4>
<p>管理航班功能可以帮助用户在Flight表中添加、修改或删除航班记录，并提供相应接口供其他功能元素调用（如获取航班信息、更新航班状态等）。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“管理航班”按钮，进入航班管理界面。</li>
<li>在航班管理界面，系统会显示Flight表中所有航班的信息，包括航班号、出发时间、到达时间、状态等。用户可以对航班信息进行以下操作：</li>

</ol>
<p>–  添加：点击“添加”按钮，进入添加航班界面，在该界面输入一个新的航班号和其他必要的属性（如出发时间、到达时间、状态等），并点击“确认”按钮。如果没有输入任何属性，则显示“请输入必要的属性”。如果输入了一个已存在的航班号，则显示“航班号已存在，请重新输入”。如果输入了一个新的且有效的航班号和其他必要的属性，则在Flight表中创建新记录，并返回到航班管理界面。</p>
<p>–  修改：点击每个航班信息后面的“修改”按钮，进入修改航班界面，在该界面更改该航班的任何属性（如出发时间、到达时间、状态等），并点击“确认”按钮。如果没有更改任何属性，则显示“没有更改任何属性”。如果更改了任何属性，则在Flight表中更新相应记录，并返回到航班管理界面。</p>
<p>–  删除：点击每个航班信息后面的“删除”按钮，需要点击“确认”按钮确认删除操作。如果确认删除，则在Flight表中删除相应记录，并返回到航班管理界面。</p>
<p>–  查询：点击“查询”按钮，进入查询条件输入界面，在该界面输入或选择一个或多个查询条件（如出发地、目的地、日期等），并点击“查询”按钮。如果没有输入或选择任何查询条件，则显示</p>
<p>–  查询：点击“查询”按钮，进入查询条件输入界面，在该界面输入或选择一个或多个查询条件（如出发地、目的地、日期等），并点击“查询”按钮。如果没有输入或选择任何查询条件，则显示“请输入或选择一个或多个查询条件”。如果输入或选择了一个或多个查询条件，则在Flight表中查找符合条件的航班，并显示相关信息给用户。用户可以对查询结果进行排序、筛选操作。</p>
<p>&nbsp;</p>
<h4 id='6-管理飞机'>6. 管理飞机</h4>
<p>管理飞机功能可以帮助用户在Aircraft表中添加、修改或删除飞机记录，并提供相应接口供其他功能元素调用（如获取飞机类型、获取飞机座位数目等）。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“管理飞机”按钮，进入飞机管理界面。</li>
<li>在飞机管理界面，系统会显示Aircraft表中所有飞机的信息，包括飞机号、类型、座位数目等。用户可以对飞机信息进行以下操作：</li>

</ol>
<p>–  添加：点击“添加”按钮，进入添加飞机界面，在该界面输入一个新的飞机号和其他必要的属性（如类型、座位数目等），并点击“确认”按钮。如果没有输入任何属性，则显示“请输入必要的属性”。如果输入了一个已存在的飞机号，则显示“飞机号已存在，请重新输入”。如果输入了一个新的且有效的飞机号和其他必要的属性，则在Aircraft表中创建新记录，并返回到飞机管理界面。</p>
<p>–  修改：点击每个飞机信息后面的“修改”按钮，进入修改飞机界面，在该界面更改该飞机的任何属性（如类型、座位数目等），并点击“确认”按钮。如果没有更改任何属性，则显示“没有更改任何属性”。如果更改了任何属性，则在Aircraft表中更新相应记录，并返回到飞机管理界面。</p>
<p>–  删除：点击每个飞机信息后面的“删除”按钮，需要点击“确认”按钮确认删除操作。如果确认删除，则在Aircraft表中删除相应记录，并返回到飞机管理界面。</p>
<p>–  查询：点击“查询”按钮，进入查询条件输入界面，在该界面输入或选择一个或多个查询条件（如类型、座位数目等），并点击“查询”按钮。如果没有输入或选择任何查询条件，则显示“请输入或选择一个或多个查询条件”。如果输入或选择了一个或多个查询条件，则在Aircraft表中查找符合条件的飞机，并显示相关信息给用户。用户可以对查询结果进行排序、筛选等操作。</p>
<p>&nbsp;</p>
<h4 id='7-管理机场'>7. 管理机场</h4>
<p>管理机场功能可以帮助用户在Airport表中添加、修改或删除机场记录，并提供相应接口供其他功能元素调用（如获取机场代码、获取机场名称等）。操作步骤如下：</p>
<ol>
<li>打开系统主界面，点击“管理机场”按钮，进入机场管理界面。</li>
<li>在机场管理界面，系统会显示Airport表中所有机场的信息，包括机场代码、名称等。用户可以对机场信息进行以下操作：</li>

</ol>
<p>–  添加：点击“添加”按钮，进入添加机场界面，在该界面输入一个新的机场代码和其他必要的属性（如名称等），并点击“确认”按钮。如果没有输入任何属性，则显示“请输入必要的属性”。如果输入了一个已存在的机场代码，则显示“机场代码已存在，请重新输入”。如果输入了一个新的且有效的机场代码和其他必要的属性，则在Airport表中创建新记录，并返回到机场管理界面。</p>
<p>–  修改：点击每个机场信息后面的“修改”按钮，进入修改机场界面，在该界面更改该机场的任何属性（如名称等），并点击“确认”按钮。如果没有更改任何属性，则显示“没有更改任何属性”。如果更改了任何属性，则在Airport表中更新相应记录，并返回到机场管理界面。</p>
<p>–  删除：点击每个机场信息后面的“删除”按钮，需要点击“确认”按钮确认删除操作。如果确认删除，则在Airport表中删除相应记录，并返回到机场管理界面。</p>
<p>–  查询：点击“查询”按钮，进入查询条件输入界面，在该界面输入或选择一个或多个查询条件（如代码、名称等），并点击“查询”按钮。如果没有输入或选择任何查询条件，则显示“请输入或选择一个或多个查询条件”。如果输入或选择了一个或多个查询条件，则在Airport表中查找符合条件的机场，并显示相关信息给用户。用户可以对查询结果进行排序、筛选操作。</p>
<p>&nbsp;</p>
<h2 id='五总结'>五、总结</h2>
<p>&nbsp;</p>
<p>在本次航班机票预订系统的开发过程中，我遇到了不少困难。例如，我对数据库的外键的创建不太熟悉；对ER图的绘制也不太熟练，在确定实体和关系类型时出现了一定困难；对Java的基础知识已经有较多遗忘对Swing图形界面开发也一窍不通（以前没有学习过Swing，学过的FX配置环境比较复杂，配置后功能有问题，组件显示不出，网上相关问题较少，可能是编辑器的问题？）。</p>
<p>但是，通过不断上网查找资料学习，查阅官方文档，观看视频教程，我最终还是完成了本次系统的开发。系统的设计阶段进展比较顺利，但也遇到了一些细节上思考不周全的问题，比如起初没有考虑到机场。在绘制ER图时，我也出现了较多细节问题，如关系名称的不规范使用和中英文混用等。在创建数据库时，我从一开始不知道SQL源文件是如何编写的，学习了相关语法和格式后，到现在已经可以独立编写一个完整的、可被source命令导入的SQL文件，很有成就感。最后，凭借大一时学习的Java基础知识，加上这次项目的练习，我比较顺利地完成了命令行终端的输入输出。但是在Java图形化界面开发中遇到了比较大的困难，一直无法在表格中动态显示数据库中的内容。经过两天的尝试，我最终没有找到令人满意的解决方案，只完成了首页的静态开发。</p>
</template>

<script>

</script>


<link href='https://fonts.loli.net/css?family=Open+Sans:400italic,700italic,700,400&subset=latin,latin-ext' rel='stylesheet' type='text/css' /><style type='text/css'>html {overflow-x: initial !important;}:root { --bg-color:#ffffff; --text-color:#333333; --select-text-bg-color:#B5D6FC; --select-text-font-color:auto; --monospace:"Lucida Console",Consolas,"Courier",monospace; --title-bar-height:20px; }
.mac-os-11 { --title-bar-height:28px; }
html { font-size: 14px; background-color: var(--bg-color); color: var(--text-color); font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; }
h1, h2, h3, h4, h5 { white-space: pre-wrap; }
body { margin: 0px; padding: 0px; height: auto; inset: 0px; font-size: 1rem; line-height: 1.42857; overflow-x: hidden; background: inherit; tab-size: 4; }
iframe { margin: auto; }
a.url { word-break: break-all; }
a:active, a:hover { outline: 0px; }
.in-text-selection, ::selection { text-shadow: none; background: var(--select-text-bg-color); color: var(--select-text-font-color); }
#write { margin: 0px auto; height: auto; width: inherit; word-break: normal; overflow-wrap: break-word; position: relative; white-space: normal; overflow-x: visible; padding-top: 36px; }
#write.first-line-indent p { text-indent: 2em; }
#write.first-line-indent li p, #write.first-line-indent p * { text-indent: 0px; }
#write.first-line-indent li { margin-left: 2em; }
.for-image #write { padding-left: 8px; padding-right: 8px; }
body.typora-export { padding-left: 30px; padding-right: 30px; }
.typora-export .footnote-line, .typora-export li, .typora-export p { white-space: pre-wrap; }
.typora-export .task-list-item input { pointer-events: none; }
@media screen and (max-width: 500px) {
  body.typora-export { padding-left: 0px; padding-right: 0px; }
  #write { padding-left: 20px; padding-right: 20px; }
}
#write li > figure:last-child { margin-bottom: 0.5rem; }
#write ol, #write ul { position: relative; }
img { max-width: 100%; vertical-align: middle; image-orientation: from-image; }
button, input, select, textarea { color: inherit; font: inherit; }
input[type="checkbox"], input[type="radio"] { line-height: normal; padding: 0px; }
*, ::after, ::before { box-sizing: border-box; }
#write h1, #write h2, #write h3, #write h4, #write h5, #write h6, #write p, #write pre { width: inherit; }
#write h1, #write h2, #write h3, #write h4, #write h5, #write h6, #write p { position: relative; }
p { line-height: inherit; }
h1, h2, h3, h4, h5, h6 { break-after: avoid-page; break-inside: avoid; orphans: 4; }
p { orphans: 4; }
h1 { font-size: 2rem; }
h2 { font-size: 1.8rem; }
h3 { font-size: 1.6rem; }
h4 { font-size: 1.4rem; }
h5 { font-size: 1.2rem; }
h6 { font-size: 1rem; }
.md-math-block, .md-rawblock, h1, h2, h3, h4, h5, h6, p { margin-top: 1rem; margin-bottom: 1rem; }
.hidden { display: none; }
.md-blockmeta { color: rgb(204, 204, 204); font-weight: 700; font-style: italic; }
a { cursor: pointer; }
sup.md-footnote { padding: 2px 4px; background-color: rgba(238, 238, 238, 0.7); color: rgb(85, 85, 85); border-radius: 4px; cursor: pointer; }
sup.md-footnote a, sup.md-footnote a:hover { color: inherit; text-transform: inherit; text-decoration: inherit; }
#write input[type="checkbox"] { cursor: pointer; width: inherit; height: inherit; }
figure { overflow-x: auto; margin: 1.2em 0px; max-width: calc(100% + 16px); padding: 0px; }
figure > table { margin: 0px; }
thead, tr { break-inside: avoid; break-after: auto; }
thead { display: table-header-group; }
table { border-collapse: collapse; border-spacing: 0px; width: 100%; overflow: auto; break-inside: auto; text-align: left; }
table.md-table td { min-width: 32px; }
.CodeMirror-gutters { border-right: 0px; background-color: inherit; }
.CodeMirror-linenumber { user-select: none; }
.CodeMirror { text-align: left; }
.CodeMirror-placeholder { opacity: 0.3; }
.CodeMirror pre { padding: 0px 4px; }
.CodeMirror-lines { padding: 0px; }
div.hr:focus { cursor: none; }
#write pre { white-space: pre-wrap; }
#write.fences-no-line-wrapping pre { white-space: pre; }
#write pre.ty-contain-cm { white-space: normal; }
.CodeMirror-gutters { margin-right: 4px; }
.md-fences { font-size: 0.9rem; display: block; break-inside: avoid; text-align: left; overflow: visible; white-space: pre; background: inherit; position: relative !important; }
.md-fences-adv-panel { width: 100%; margin-top: 10px; text-align: center; padding-top: 0px; padding-bottom: 8px; overflow-x: auto; }
#write .md-fences.mock-cm { white-space: pre-wrap; }
.md-fences.md-fences-with-lineno { padding-left: 0px; }
#write.fences-no-line-wrapping .md-fences.mock-cm { white-space: pre; overflow-x: auto; }
.md-fences.mock-cm.md-fences-with-lineno { padding-left: 8px; }
.CodeMirror-line, twitterwidget { break-inside: avoid; }
svg { break-inside: avoid; }
.footnotes { opacity: 0.8; font-size: 0.9rem; margin-top: 1em; margin-bottom: 1em; }
.footnotes + .footnotes { margin-top: 0px; }
.md-reset { margin: 0px; padding: 0px; border: 0px; outline: 0px; vertical-align: top; background: 0px 0px; text-decoration: none; text-shadow: none; float: none; position: static; width: auto; height: auto; white-space: nowrap; cursor: inherit; -webkit-tap-highlight-color: transparent; line-height: normal; font-weight: 400; text-align: left; box-sizing: content-box; direction: ltr; }
li div { padding-top: 0px; }
blockquote { margin: 1rem 0px; }
li .mathjax-block, li p { margin: 0.5rem 0px; }
li blockquote { margin: 1rem 0px; }
li { margin: 0px; position: relative; }
blockquote > :last-child { margin-bottom: 0px; }
blockquote > :first-child, li > :first-child { margin-top: 0px; }
.footnotes-area { color: rgb(136, 136, 136); margin-top: 0.714rem; padding-bottom: 0.143rem; white-space: normal; }
#write .footnote-line { white-space: pre-wrap; }
@media print {
  body, html { border: 1px solid transparent; height: 99%; break-after: avoid; break-before: avoid; font-variant-ligatures: no-common-ligatures; }
  #write { margin-top: 0px; border-color: transparent !important; padding-top: 0px !important; padding-bottom: 0px !important; }
  .typora-export * { -webkit-print-color-adjust: exact; }
  .typora-export #write { break-after: avoid; }
  .typora-export #write::after { height: 0px; }
  .is-mac table { break-inside: avoid; }
  #write > p:nth-child(1) { margin-top: 0px; }
  .typora-export-show-outline .typora-export-sidebar { display: none; }
  figure { overflow-x: visible; }
}
.footnote-line { margin-top: 0.714em; font-size: 0.7em; }
a img, img a { cursor: pointer; }
pre.md-meta-block { font-size: 0.8rem; min-height: 0.8rem; white-space: pre-wrap; background: rgb(204, 204, 204); display: block; overflow-x: hidden; }
p > .md-image:only-child:not(.md-img-error) img, p > img:only-child { display: block; margin: auto; }
#write.first-line-indent p > .md-image:only-child:not(.md-img-error) img { left: -2em; position: relative; }
p > .md-image:only-child { display: inline-block; width: 100%; }
#write .MathJax_Display { margin: 0.8em 0px 0px; }
.md-math-block { width: 100%; }
.md-math-block:not(:empty)::after { display: none; }
.MathJax_ref { fill: currentcolor; }
[contenteditable="true"]:active, [contenteditable="true"]:focus, [contenteditable="false"]:active, [contenteditable="false"]:focus { outline: 0px; box-shadow: none; }
.md-task-list-item { position: relative; list-style-type: none; }
.task-list-item.md-task-list-item { padding-left: 0px; }
.md-task-list-item > input { position: absolute; top: 0px; left: 0px; margin-left: -1.2em; margin-top: calc(1em - 10px); border: none; }
.math { font-size: 1rem; }
.md-toc { min-height: 3.58rem; position: relative; font-size: 0.9rem; border-radius: 10px; }
.md-toc-content { position: relative; margin-left: 0px; }
.md-toc-content::after, .md-toc::after { display: none; }
.md-toc-item { display: block; color: rgb(65, 131, 196); }
.md-toc-item a { text-decoration: none; }
.md-toc-inner:hover { text-decoration: underline; }
.md-toc-inner { display: inline-block; cursor: pointer; }
.md-toc-h1 .md-toc-inner { margin-left: 0px; font-weight: 700; }
.md-toc-h2 .md-toc-inner { margin-left: 2em; }
.md-toc-h3 .md-toc-inner { margin-left: 4em; }
.md-toc-h4 .md-toc-inner { margin-left: 6em; }
.md-toc-h5 .md-toc-inner { margin-left: 8em; }
.md-toc-h6 .md-toc-inner { margin-left: 10em; }
@media screen and (max-width: 48em) {
  .md-toc-h3 .md-toc-inner { margin-left: 3.5em; }
  .md-toc-h4 .md-toc-inner { margin-left: 5em; }
  .md-toc-h5 .md-toc-inner { margin-left: 6.5em; }
  .md-toc-h6 .md-toc-inner { margin-left: 8em; }
}
a.md-toc-inner { font-size: inherit; font-style: inherit; font-weight: inherit; line-height: inherit; }
.footnote-line a:not(.reversefootnote) { color: inherit; }
.reversefootnote { font-family: ui-monospace, sans-serif; }
.md-attr { display: none; }
.md-fn-count::after { content: "."; }
code, pre, samp, tt { font-family: var(--monospace); }
kbd { margin: 0px 0.1em; padding: 0.1em 0.6em; font-size: 0.8em; color: rgb(36, 39, 41); background: rgb(255, 255, 255); border: 1px solid rgb(173, 179, 185); border-radius: 3px; box-shadow: rgba(12, 13, 14, 0.2) 0px 1px 0px, rgb(255, 255, 255) 0px 0px 0px 2px inset; white-space: nowrap; vertical-align: middle; }
.md-comment { color: rgb(162, 127, 3); opacity: 0.6; font-family: var(--monospace); }
code { text-align: left; vertical-align: initial; }
a.md-print-anchor { white-space: pre !important; border-width: initial !important; border-style: none !important; border-color: initial !important; display: inline-block !important; position: absolute !important; width: 1px !important; right: 0px !important; outline: 0px !important; background: 0px 0px !important; text-decoration: initial !important; text-shadow: initial !important; }
.os-windows.monocolor-emoji .md-emoji { font-family: "Segoe UI Symbol", sans-serif; }
.md-diagram-panel > svg { max-width: 100%; }
[lang="flow"] svg, [lang="mermaid"] svg { max-width: 100%; height: auto; }
[lang="mermaid"] .node text { font-size: 1rem; }
table tr th { border-bottom: 0px; }
video { max-width: 100%; display: block; margin: 0px auto; }
iframe { max-width: 100%; width: 100%; border: none; }
.highlight td, .highlight tr { border: 0px; }
mark { background: rgb(255, 255, 0); color: rgb(0, 0, 0); }
.md-html-inline .md-plain, .md-html-inline strong, mark .md-inline-math, mark strong { color: inherit; }
.md-expand mark .md-meta { opacity: 0.3 !important; }
mark .md-meta { color: rgb(0, 0, 0); }
@media print {
  .typora-export h1, .typora-export h2, .typora-export h3, .typora-export h4, .typora-export h5, .typora-export h6 { break-inside: avoid; }
}
.md-diagram-panel .messageText { stroke: none !important; }
.md-diagram-panel .start-state { fill: var(--node-fill); }
.md-diagram-panel .edgeLabel rect { opacity: 1 !important; }
.md-fences.md-fences-math { font-size: 1em; }
.md-fences-advanced:not(.md-focus) { padding: 0px; white-space: nowrap; border: 0px; }
.md-fences-advanced:not(.md-focus) { background: inherit; }
.typora-export-show-outline .typora-export-content { max-width: 1440px; margin: auto; display: flex; flex-direction: row; }
.typora-export-sidebar { width: 300px; font-size: 0.8rem; margin-top: 80px; margin-right: 18px; }
.typora-export-show-outline #write { --webkit-flex:2; flex: 2 1 0%; }
.typora-export-sidebar .outline-content { position: fixed; top: 0px; max-height: 100%; overflow: hidden auto; padding-bottom: 30px; padding-top: 60px; width: 300px; }
@media screen and (max-width: 1024px) {
  .typora-export-sidebar, .typora-export-sidebar .outline-content { width: 240px; }
}
@media screen and (max-width: 800px) {
  .typora-export-sidebar { display: none; }
}
.outline-content li, .outline-content ul { margin-left: 0px; margin-right: 0px; padding-left: 0px; padding-right: 0px; list-style: none; overflow-wrap: anywhere; }
.outline-content ul { margin-top: 0px; margin-bottom: 0px; }
.outline-content strong { font-weight: 400; }
.outline-expander { width: 1rem; height: 1.42857rem; position: relative; display: table-cell; vertical-align: middle; cursor: pointer; padding-left: 4px; }
.outline-expander::before { content: ""; position: relative; font-family: Ionicons; display: inline-block; font-size: 8px; vertical-align: middle; }
.outline-item { padding-top: 3px; padding-bottom: 3px; cursor: pointer; }
.outline-expander:hover::before { content: ""; }
.outline-h1 > .outline-item { padding-left: 0px; }
.outline-h2 > .outline-item { padding-left: 1em; }
.outline-h3 > .outline-item { padding-left: 2em; }
.outline-h4 > .outline-item { padding-left: 3em; }
.outline-h5 > .outline-item { padding-left: 4em; }
.outline-h6 > .outline-item { padding-left: 5em; }
.outline-label { cursor: pointer; display: table-cell; vertical-align: middle; text-decoration: none; color: inherit; }
.outline-label:hover { text-decoration: underline; }
.outline-item:hover { border-color: rgb(245, 245, 245); background-color: var(--item-hover-bg-color); }
.outline-item:hover { margin-left: -28px; margin-right: -28px; border-left: 28px solid transparent; border-right: 28px solid transparent; }
.outline-item-single .outline-expander::before, .outline-item-single .outline-expander:hover::before { display: none; }
.outline-item-open > .outline-item > .outline-expander::before { content: ""; }
.outline-children { display: none; }
.info-panel-tab-wrapper { display: none; }
.outline-item-open > .outline-children { display: block; }
.typora-export .outline-item { padding-top: 1px; padding-bottom: 1px; }
.typora-export .outline-item:hover { margin-right: -8px; border-right: 8px solid transparent; }
.typora-export .outline-expander::before { content: "+"; font-family: inherit; top: -1px; }
.typora-export .outline-expander:hover::before, .typora-export .outline-item-open > .outline-item > .outline-expander::before { content: "−"; }
.typora-export-collapse-outline .outline-children { display: none; }
.typora-export-collapse-outline .outline-item-open > .outline-children, .typora-export-no-collapse-outline .outline-children { display: block; }
.typora-export-no-collapse-outline .outline-expander::before { content: "" !important; }
.typora-export-show-outline .outline-item-active > .outline-item .outline-label { font-weight: 700; }
.md-inline-math-container mjx-container { zoom: 0.95; }
mjx-container { break-inside: avoid; }


:root {
    --side-bar-bg-color: #fafafa;
    --control-text-color: #777;
}

@include-when-export url(https://fonts.loli.net/css?family=Open+Sans:400italic,700italic,700,400&subset=latin,latin-ext);

/* open-sans-regular - latin-ext_latin */
  /* open-sans-italic - latin-ext_latin */
    /* open-sans-700 - latin-ext_latin */
    /* open-sans-700italic - latin-ext_latin */
  html {
    font-size: 16px;
    -webkit-font-smoothing: antialiased;
}

body {
    font-family: "Open Sans","Clear Sans", "Helvetica Neue", Helvetica, Arial, 'Segoe UI Emoji', sans-serif;
    color: rgb(51, 51, 51);
    line-height: 1.6;
}

#write {
    max-width: 860px;
  	margin: 0 auto;
  	padding: 30px;
    padding-bottom: 100px;
}

@media only screen and (min-width: 1400px) {
	#write {
		max-width: 1024px;
	}
}

@media only screen and (min-width: 1800px) {
	#write {
		max-width: 1200px;
	}
}

#write > ul:first-child,
#write > ol:first-child{
    margin-top: 30px;
}

a {
    color: #4183C4;
}
h1,
h2,
h3,
h4,
h5,
h6 {
    position: relative;
    margin-top: 1rem;
    margin-bottom: 1rem;
    font-weight: bold;
    line-height: 1.4;
    cursor: text;
}
h1:hover a.anchor,
h2:hover a.anchor,
h3:hover a.anchor,
h4:hover a.anchor,
h5:hover a.anchor,
h6:hover a.anchor {
    text-decoration: none;
}
h1 tt,
h1 code {
    font-size: inherit;
}
h2 tt,
h2 code {
    font-size: inherit;
}
h3 tt,
h3 code {
    font-size: inherit;
}
h4 tt,
h4 code {
    font-size: inherit;
}
h5 tt,
h5 code {
    font-size: inherit;
}
h6 tt,
h6 code {
    font-size: inherit;
}
h1 {
    font-size: 2.25em;
    line-height: 1.2;
    border-bottom: 1px solid #eee;
}
h2 {
    font-size: 1.75em;
    line-height: 1.225;
    border-bottom: 1px solid #eee;
}

/*@media print {
    .typora-export h1,
    .typora-export h2 {
        border-bottom: none;
        padding-bottom: initial;
    }

    .typora-export h1::after,
    .typora-export h2::after {
        content: "";
        display: block;
        height: 100px;
        margin-top: -96px;
        border-top: 1px solid #eee;
    }
}*/

h3 {
    font-size: 1.5em;
    line-height: 1.43;
}
h4 {
    font-size: 1.25em;
}
h5 {
    font-size: 1em;
}
h6 {
   font-size: 1em;
    color: #777;
}
p,
blockquote,
ul,
ol,
dl,
table{
    margin: 0.8em 0;
}
li>ol,
li>ul {
    margin: 0 0;
}
hr {
    height: 2px;
    padding: 0;
    margin: 16px 0;
    background-color: #e7e7e7;
    border: 0 none;
    overflow: hidden;
    box-sizing: content-box;
}

li p.first {
    display: inline-block;
}
ul,
ol {
    padding-left: 30px;
}
ul:first-child,
ol:first-child {
    margin-top: 0;
}
ul:last-child,
ol:last-child {
    margin-bottom: 0;
}
blockquote {
    border-left: 4px solid #dfe2e5;
    padding: 0 15px;
    color: #777777;
}
blockquote blockquote {
    padding-right: 0;
}
table {
    padding: 0;
    word-break: initial;
}
table tr {
    border: 1px solid #dfe2e5;
    margin: 0;
    padding: 0;
}
table tr:nth-child(2n),
thead {
    background-color: #f8f8f8;
}
table th {
    font-weight: bold;
    border: 1px solid #dfe2e5;
    border-bottom: 0;
    margin: 0;
    padding: 6px 13px;
}
table td {
    border: 1px solid #dfe2e5;
    margin: 0;
    padding: 6px 13px;
}
table th:first-child,
table td:first-child {
    margin-top: 0;
}
table th:last-child,
table td:last-child {
    margin-bottom: 0;
}

.CodeMirror-lines {
    padding-left: 4px;
}

.code-tooltip {
    box-shadow: 0 1px 1px 0 rgba(0,28,36,.3);
    border-top: 1px solid #eef2f2;
}

.md-fences,
code,
tt {
    border: 1px solid #e7eaed;
    background-color: #f8f8f8;
    border-radius: 3px;
    padding: 0;
    padding: 2px 4px 0px 4px;
    font-size: 0.9em;
}

code {
    background-color: #f3f4f4;
    padding: 0 2px 0 2px;
}

.md-fences {
    margin-bottom: 15px;
    margin-top: 15px;
    padding-top: 8px;
    padding-bottom: 6px;
}


.md-task-list-item > input {
  margin-left: -1.3em;
}

@media print {
    html {
        font-size: 13px;
    }
    pre {
        page-break-inside: avoid;
        word-wrap: break-word;
    }
}

.md-fences {
	background-color: #f8f8f8;
}
#write pre.md-meta-block {
	padding: 1rem;
    font-size: 85%;
    line-height: 1.45;
    background-color: #f7f7f7;
    border: 0;
    border-radius: 3px;
    color: #777777;
    margin-top: 0 !important;
}

.mathjax-block>.code-tooltip {
	bottom: .375rem;
}

.md-mathjax-midline {
    background: #fafafa;
}

#write>h3.md-focus:before{
	left: -1.5625rem;
	top: .375rem;
}
#write>h4.md-focus:before{
	left: -1.5625rem;
	top: .285714286rem;
}
#write>h5.md-focus:before{
	left: -1.5625rem;
	top: .285714286rem;
}
#write>h6.md-focus:before{
	left: -1.5625rem;
	top: .285714286rem;
}
.md-image>.md-meta {
    /*border: 1px solid #ddd;*/
    border-radius: 3px;
    padding: 2px 0px 0px 4px;
    font-size: 0.9em;
    color: inherit;
}

.md-tag {
    color: #a7a7a7;
    opacity: 1;
}

.md-toc { 
    margin-top:20px;
    padding-bottom:20px;
}

.sidebar-tabs {
    border-bottom: none;
}

#typora-quick-open {
    border: 1px solid #ddd;
    background-color: #f8f8f8;
}

#typora-quick-open-item {
    background-color: #FAFAFA;
    border-color: #FEFEFE #e5e5e5 #e5e5e5 #eee;
    border-style: solid;
    border-width: 1px;
}

/** focus mode */
.on-focus-mode blockquote {
    border-left-color: rgba(85, 85, 85, 0.12);
}

header, .context-menu, .megamenu-content, footer{
    font-family: "Segoe UI", "Arial", sans-serif;
}

.file-node-content:hover .file-node-icon,
.file-node-content:hover .file-node-open-state{
    visibility: visible;
}

.mac-seamless-mode #typora-sidebar {
    background-color: #fafafa;
    background-color: var(--side-bar-bg-color);
}

.md-lang {
    color: #b4654d;
}

/*.html-for-mac {
    --item-hover-bg-color: #E6F0FE;
}*/

#md-notification .btn {
    border: 0;
}

.dropdown-menu .divider {
    border-color: #e5e5e5;
    opacity: 0.4;
}

.ty-preferences .window-content {
    background-color: #fafafa;
}

.ty-preferences .nav-group-item.active {
    color: white;
    background: #999;
}

.menu-item-container a.menu-style-btn {
    background-color: #f5f8fa;
    background-image: linear-gradient( 180deg , hsla(0, 0%, 100%, 0.8), hsla(0, 0%, 100%, 0)); 
}



</style>