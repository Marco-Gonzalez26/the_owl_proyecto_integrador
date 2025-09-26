import { ChartConfig, ChartContainer, ChartTooltip, ChartTooltipContent } from '@/components/ui/chart';
import { Bar, BarChart, CartesianGrid, XAxis } from 'recharts';

export const Chart = ({ chartData, chartConfig }: { chartData: any; chartConfig: ChartConfig }) => {
    return (
        <ChartContainer config={chartConfig} className="h-[300px] w-full">
            <BarChart accessibilityLayer data={chartData}>
                <CartesianGrid vertical={false} />
                <XAxis dataKey="month" tickLine={false} tickMargin={10} axisLine={false} tickFormatter={(value) => value.slice(0, 3)} />
                <ChartTooltip content={<ChartTooltipContent />} />
                <Bar dataKey="pedidos" name="Ventas" fill="var(--chart-3)" radius={[10, 10, 0, 0]} />
            </BarChart>
        </ChartContainer>
    );
};
